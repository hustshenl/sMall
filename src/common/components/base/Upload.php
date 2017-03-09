<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/5 21:02
 * @Description:
 */

namespace common\components\base;

use Imagine\Image\ManipulatorInterface;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\web\BadRequestHttpException;
use yii\imagine\Image as Imagine;
use yii\imagine\BaseImage;
use yii;
use yii\helpers\ArrayHelper;

/**
 * Class Upload
 * 负责文件上传
 * @package common\components
 * @property \yii\base\Model $model
 * @property string $fileExt
 * @property string $path
 * @property string $fileName
 * @property array $errors
 * @property string $firstError
 * @property ImageInterface $imagine
 * @property UploadedFile $instance
 */
class Upload extends Component {

    const CATEGORY_COMMON = 'common';
    const CATEGORY_GOODS = 'goods';
    const CATEGORY_MEMBER = 'member';
    const CATEGORY_ARTICLE = 'article';
    const CATEGORY_BLOCK = 'block';
    const CATEGORY_STORE = 'store';
    const CATEGORY_TEMP = 'temp';

    public $field='image';
    public $category = self::CATEGORY_COMMON;
    public $cropImage;

    private $_model;
    private $_instance = false;
    private $_path;
    private $_fileName=false;
    private $_fileExt;
    private $_imagine;
    //public $fileName;
    private $_saveOriginal=-1;
    private $_imageExt='jpg|jpeg|png|gif|bmp';
    private $_errors=[];


    public function init()
    {
        parent::init();
    }

    /**
     * 获取上传文件实例
     * @return bool|UploadedFile
     */
    public function getInstance()
    {
        if($this->_instance == false) $this->_instance = UploadedFile::getInstance($this->model, $this->field);
        return $this->_instance;
    }
    public function isOutOfSize()
    {
        if(!$this->instance) return true;
        $maxSize = isset(Yii::$app->params['upload']['maxSize'])?Yii::$app->params['upload']['maxSize']:2048;
        if ($this->instance->size > 1024 * $maxSize) {
            $this->model->addError($this->field, sprintf('文件太大,请上传小于 %s K的图片', $maxSize));
            $this->addError(sprintf('文件太大,请上传小于 %s K的图片', $maxSize));
            return true;
        }
        return false;
    }

    public function loadImage()
    {
        if($this->isOutOfSize()||!$this->isImage()) {
            return false;
        }
        Yii::trace($this->isSaveOriginal());
        if(!$this->isSaveOriginal()){
            $this->crop();
            $this->thumbnail();
        }
        return true;
    }

    public function crop()
    {
        Yii::trace($this->isCropable());
        if(!$this->isCropable()) return $this->imagine;
        $cropField = $this->field.'_crop';
        $this->_imagine =  Imagine::crop($this->instance->tempName, $this->model->{$cropField}['width'], $this->model->{$cropField}['height'], [$this->model->{$cropField}['x'],$this->model->{$cropField}['y']]);
        return $this->_imagine;
    }
    public function isCropable()
    {
        Yii::trace($this->model->attributes);
        return isset($this->model->{$this->field.'_crop'});
    }

    /**
     * @param $size string
     * @return \Imagine\Image\ImageInterface
     */
    public function thumbnail($size='md')
    {
        $field = $this->field;
        $ratioConfig = ['xl'=>2,'lg'=>1.5,'md'=>1,'sm'=>0.75,'xs'=>0.5];
        $ratio = is_numeric($size)? $size : $ratioConfig[$size];
        $width = isset(Yii::$app->params[$field]['width'])&&Yii::$app->params[$field]['width']>0?Yii::$app->params[$field]['width']:240;
        $height = isset(Yii::$app->params[$field]['height'])&&Yii::$app->params[$field]['height']>0?Yii::$app->params[$field]['height']:320;
        $box = new Box($width*$ratio, $height*$ratio);
        return $this->imagine->copy()->thumbnail($box,ManipulatorInterface::THUMBNAIL_OUTBOUND);
    }
    public function isSaveOriginal()
    {
        if($this->_saveOriginal == -1) $this->_saveOriginal =  isset(Yii::$app->params['upload'][$this->category]['saveOriginal'])&&Yii::$app->params['upload'][$this->category]['saveOriginal'];
        return $this->_saveOriginal;
    }
    public function setSaveOriginal($flag)
    {
        $this->_saveOriginal = $flag;
    }
    public function getImagine()
    {
        if(empty($this->_imagine)) $this->_imagine = Imagine::getImagine()->open($this->instance->tempName);
        return $this->_imagine;
    }
    public function save($original=false)
    {
        if($original||$this->isSaveOriginal()){
            return Yii::$app->fs->writeStream($this->path . $this->fileName, fopen($this->instance->tempName, 'r+'));
        }
        return Yii::$app->fs->write($this->path . $this->fileName,
            $this->imagine->get('jpeg', ['quality' => static::getQualityConfig($this->category)]));
    }

    public function getFileName()
    {
        if(!$this->_fileName) $this->_fileName = $this->generateFileName($this->path,$this->fileExt);
        return $this->_fileName;
    }
    public function clearFileName()
    {
        $this->_fileName = false;
    }

    /**
     * 根据路径和后缀生成文件名
     * @param $path
     * @param $ext
     * @return string
     */
    public static function generateFileName($path,$ext='jpg')
    {
        do {
            $_randName = time() .Yii::$app->security->generateRandomString(16);
            $fileName = $_randName . "." . $ext;
        } while (Yii::$app->fs->has(rtrim($path,'/'). '/' . $fileName));
        return $fileName;
    }

    /**
     * 生成临时目录
     * @return string
     */
    public static function generateTempDir()
    {
        $path = static::getBasePath(Upload::CATEGORY_TEMP);
        do {
            $name = time() .Yii::$app->security->generateRandomString(16);
            $dir = $path.$name.'/';
        } while (Yii::$app->fs->has($dir));
        Yii::$app->fs->createDir($dir);
        return $dir;
    }

    /**
     * 判断上传文件是否为图片类型
     * @return bool
     */
    public function isImage()
    {
        if(function_exists('exif_imagetype')){
            $exifImageType = exif_imagetype($this->instance->tempName);
            if($exifImageType == IMAGETYPE_BMP||$exifImageType == IMAGETYPE_GIF||$exifImageType == IMAGETYPE_JPEG||$exifImageType == IMAGETYPE_PNG){
                return true;
            }
        }else{
            if($this->fileExt != false && stripos($this->_imageExt, $this->fileExt)>-1) return true;
        }
        $this->addError('上传文件非图片文件');
        return false;
    }



    public function getFileExt()
    {
        return $this->_fileExt ? $this->_fileExt : $this->_fileExt = $this->instance->getExtension();
    }
    public function getPath()
    {
        if(!$this->_path){
            $this->_path = static::getBasePath($this->category);
            $this->_path .= date('Ym', time()).'/';
        }
        return $this->_path;
    }
    public function setPath($path)
    {
        $this->_path = $path;
    }


    public function setModel($model)
    {
        $this->_model = $model;
    }

    public function getModel()
    {
        if(!$this->_model) throw new BadRequestHttpException('Model 没有配置！');
        return $this->_model;
    }

    public function getErrors()
    {
        return $this->_errors;
    }
    public function getFirstError()
    {
        $errors = $this->errors;
        return count($errors)>0 ? reset($errors) : '';
    }
    public function addError($error)
    {
        $this->_errors[] = $error;
        return false;
    }
    public function clearError()
    {
        $this->_errors = [];
    }

    public static function getBasePath($category)
    {
        if(!isset(Yii::$app->params['upload'][$category]['path'])) throw new yii\base\InvalidConfigException('配置有误');
        return Yii::$app->params['upload'][$category]['path'];
    }
    public static function getQualityConfig($category)
    {
        return isset(Yii::$app->params['upload'][$category]['quality'])?Yii::$app->params['upload'][$category]['quality']:60;
    }


    public static function uploadImage($model,$field,$category)
    {
        $upload = new Upload(['model' => $model, 'field' => $field]);
        if (!$upload->file||$upload->isOutOfSize()||!$upload->isImage()) {
            return yii\helpers\ArrayHelper::getValue($model->oldAttributes,'image','');
        }
        $path = static::getBasePath($category).date('Ym', time());
        $filename = static::generateFileName($path);
        if(Yii::$app->fs->writeStream($path . $filename, fopen($upload->file->tempName, 'r+'))){
            return $path . $filename;
        }
        return ArrayHelper::getValue($model->oldAttributes,'image','');
    }

}