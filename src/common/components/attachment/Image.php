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


/**
 * Class ImageAttachment
 * 处理图片附件上传任务，同时负责裁剪/生成缩略图
 * @package common\components
 * @property ImageInterface $imagine
 * @property array $errors
 * @property string $firstError
 */
class Image extends BaseAttachment
{

    const EVENT_AFTER_UPLOAD = 'afterUpload';

    public $category = self::CATEGORY_COMMON;
    public $field = 'image';

    private $_imagine;
    //public $fileName;
    private $_saveOriginal=-1;
    private $_imageExt='jpg|jpeg|png|gif|bmp';
    public $id;

    private $_errors = [];

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
     * @param $size string|float|integer
     * @return \Imagine\Image\ImageInterface
     */
    public function thumbnail($size='md')
    {
        $field = $this->field;
        $ratioConfig = ['xl'=>2,'lg'=>1.5,'md'=>1,'sm'=>0.75,'xs'=>0.5];
        $ratio = is_numeric($size)? $size : $ratioConfig[$size];
        $box = $this->imagine->getSize();
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


    /**
     * 生成一个附件
     * @return bool
     */
    public function create()
    {
        $upload = new Upload(['model' => $this->model, 'field' => $this->field,'category'=>$this->category]);
        $this->attachment = new AttachmentModel();
        if ($upload->loadImage() && $upload->save()) { //保存图片成功
            $this->attachment->loadUpload($upload);
            $this->attachment->category = AttachmentModel::$categories[$this->category];
            $this->attachment->model_id = $this->model->id;
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


    private function _save()
    {
        //return Yii::$app->storage->writeStream($this->path . $this->fileName, fopen($this->instance->tempName, 'r+'));
        return Yii::$app->storage->write($this->path . $this->fileName,
            $this->imagine->get('jpeg', ['quality' => static::getQualityConfig($this->category)]));
    }

    public static function getQualityConfig($category)
    {
        return isset(Yii::$app->params['upload'][$category]['quality'])?Yii::$app->params['upload'][$category]['quality']:60;
    }

    public static function uploadImage($model,$field,$category)
    {
        $upload = new Upload(['model' => $model, 'field' => $field]);
        if (!$upload->instance||$upload->isOutOfSize()||!$upload->isImage()) {
            return yii\helpers\ArrayHelper::getValue($model->oldAttributes,'image','');
        }
        $path = static::getBasePath($category).date('Ym', time());
        $filename = static::generateFileName($path);
        if(Yii::$app->storage->writeStream($path . $filename, fopen($upload->instance->tempName, 'r+'))){
            return $path . $filename;
        }
        return ArrayHelper::getValue($model->oldAttributes,'image','');
    }

}