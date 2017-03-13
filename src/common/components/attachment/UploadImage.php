<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/5 21:02
 * @Description:
 */

namespace common\components\attachment;

use common\models\base\Attachment as AttachmentModel;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\web\BadRequestHttpException;
use yii;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use yii\imagine\Image as Imagine;
use yii\imagine\BaseImage;
use yii\helpers\ArrayHelper;


/**
 * Class ImageAttachment
 * 处理图片附件上传任务，同时负责裁剪/生成缩略图
 * @package common\components
 * @property ImageInterface $imagine
 * @property array $errors
 * @property array $config
 * @property integer $qualityConfig
 * @property boolean $saveRaw
 * @property string $firstError
 */
class UploadImage extends Upload
{

    const EVENT_AFTER_UPLOAD = 'afterUpload';

    public $field = 'image';

    private $_imagine;
    private $_config;
    //private $_thumbConfig;
    private $_qualityConfig;
    //public $fileName;
    private $_saveRaw;
    private $_imageExt='jpg|jpeg|png|gif|bmp';
    public $id;

    public function load()
    {
        if($this->isOutOfSize()||!$this->isImage()) {
            return false;
        }
        Yii::trace($this->isSaveRaw());
        if(!$this->isSaveRaw()){
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
        $this->_imagine =  Imagine::crop($this->tempName, $this->model->{$cropField}['width'], $this->model->{$cropField}['height'], [$this->model->{$cropField}['x'],$this->model->{$cropField}['y']]);
        return $this->_imagine;
    }
    public function isCropable()
    {
        Yii::trace($this->model->attributes);
        return isset($this->model->{$this->field.'_crop'});
    }

    /*public function thumbnail($size='md')
    {
        $field = $this->field;
        $ratioConfig = ['xl'=>2,'lg'=>1.5,'md'=>1,'sm'=>0.75,'xs'=>0.5];
        $ratio = is_numeric($size)? $size : $ratioConfig[$size];
        $box = $this->imagine->getSize();
        $width = isset(Yii::$app->params[$field]['width'])&&Yii::$app->params[$field]['width']>0?Yii::$app->params[$field]['width']:240;
        $height = isset(Yii::$app->params[$field]['height'])&&Yii::$app->params[$field]['height']>0?Yii::$app->params[$field]['height']:320;
        $box = new Box($width*$ratio, $height*$ratio);
        return $this->imagine->copy()->thumbnail($box,ManipulatorInterface::THUMBNAIL_OUTBOUND);
    }*/

    public function getConfig()
    {
        if($this->_config === null) $this->_config =  ArrayHelper::getValue(Yii::$app->params,['upload',$this->category],[]);
        return $this->_config;
    }
    public function setConfig($config)
    {
        $this->_config  = $config;
    }
    public function getSaveRaw()
    {
        if($this->_saveRaw === null) $this->_saveRaw =  ArrayHelper::getValue($this->config,'saveRaw',false);
        return $this->_saveRaw;
    }
    public function setSaveRaw($config)
    {
        $this->_saveRaw = $config;
    }
    public function getQualityConfig()
    {
        if($this->_qualityConfig === null) $this->_qualityConfig =  ArrayHelper::getValue($this->config,'quality',false);
        return $this->_qualityConfig;
    }
    public function setQualityConfig($config=60)
    {
        return $this->_qualityConfig = $config;
    }
    /*public function getThumbConfig()
    {
        if($this->_thumbConfig === null) $this->_thumbConfig =  ArrayHelper::getValue($this->config,'thumbConfig',false);
        return $this->_thumbConfig;
    }
    public function setThumbConfig($config)
    {
        $this->_thumbConfig  = (array)$config;
    }*/
    public function getImagine()
    {
        if(empty($this->_imagine)) $this->_imagine = Imagine::getImagine()->open($this->tempName);
        return $this->_imagine;
    }


    /**
     * 判断上传文件是否为图片类型
     * @return bool
     */
    public function isImage()
    {
        if(function_exists('exif_imagetype')){
            $exifImageType = exif_imagetype($this->tempName);
            if($exifImageType == IMAGETYPE_BMP||$exifImageType == IMAGETYPE_GIF||$exifImageType == IMAGETYPE_JPEG||$exifImageType == IMAGETYPE_PNG){
                return true;
            }
        }else{
            if($this->fileExt != false && stripos($this->_imageExt, $this->fileExt)>-1) return true;
        }
        $this->addError('上传文件非图片文件');
        return false;
    }


    /**
     * 保存图片
     * @return bool
     */
    public function create()
    {
        $upload = new static(['model' => $this->model, 'field' => $this->field,'category'=>$this->category]);
        $this->attachment = new AttachmentModel();
        if ($upload->loadImage() && $upload->save()) { //保存图片成功
            $this->attachment->loadUpload($upload);
            $this->attachment->category = AttachmentModel::$categories[$this->category];
            $this->attachment->reference = 1;
            $res = $this->attachment->save();
            $this->afterCreate();
            return $res;
        }
        return true;
    }

    /**
     * 生成一个图片附件
     */
    public function createImage()
    {
        $upload = new Upload(['model' => $this->model, 'field' => $this->field,'category'=>$this->category]);
        $this->attachment = new AttachmentModel();
        if($upload->isOutOfSize()||!$upload->isImage()) {
            return false;
        }
    }

    public function afterCreate()
    {
        $this->approve();
        return true;
    }


    public function save()
    {
        //return Yii::$app->storage->writeStream($this->path . $this->fileName, fopen($this->tempName, 'r+'));
        return Yii::$app->storage->write($this->path . $this->fileName,
            $this->imagine->get('jpeg', ['quality' => static::getQualityConfig($this->category)]));
    }

    private function _saveRaw()
    {
        return Yii::$app->storage->writeStream($this->path . $this->fileName, fopen($this->tempName, 'r+'));
    }
    private function _save($imagine,$size,$quality)
    {
        //return Yii::$app->storage->writeStream($this->path . $this->fileName, fopen($this->tempName, 'r+'));
        return Yii::$app->storage->write($this->path . $this->fileName,
            $this->imagine->get('jpeg', ['quality' => $this->qualityConfig]));
    }


    public static function uploadImage($model,$field,$category)
    {
        $upload = new Upload(['model' => $model, 'field' => $field]);
        if (!$upload->instance||$upload->isOutOfSize()||!$upload->isImage()) {
            return ArrayHelper::getValue($model->oldAttributes,'image','');
        }
        $path = static::getBasePath($category).date('Ym', time());
        $filename = static::_generateFileName($path);
        if(Yii::$app->storage->writeStream($path . $filename, fopen($upload->tempName, 'r+'))){
            return $path . $filename;
        }
        return ArrayHelper::getValue($model->oldAttributes,'image','');
    }

}