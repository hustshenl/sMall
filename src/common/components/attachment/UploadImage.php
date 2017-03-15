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
use Imagine\Image\Point;
use yii\imagine\Image as Imagine;
use yii\imagine\BaseImage;
use yii\helpers\ArrayHelper;


/**
 * Class ImageAttachment
 * 处理图片附件上传任务，主要负责裁剪图片，保存原图，缩小图片尺寸，调整图片比例；
 * 系统不生成缩略图，图片缩略图在展现时进行处理
 * @package common\components
 * @property ImageInterface $imagine
 * @property array $errors
 * @property integer $qualityConfig
 * @property boolean $saveRaw
 * @property integer $maxWidth
 * @property float $resizeRatio
 * @property float $aspectRatio
 * @property string $firstError
 */
class UploadImage extends Upload
{

    const EVENT_AFTER_UPLOAD = 'afterUpload';

    public $field = 'image';

    private $_imagine;
    //private $_thumbConfig;
    private $_qualityConfig;
    private $_resizeRatio;
    private $_aspectRatio;
    private $_maxWidth;
    //private $_maxHeight;
    //public $fileName;
    private $_saveRaw;
    private $_imageExt = ['jpg','jpeg','png','gif','bmp'];
    public $id;

    public function save()
    {
        if ($this->isOutOfSize() || !$this->isImage()) {
            return false;
        }
        if($this->saveRaw){$this->_saveRaw();}
        $this->crop()->resize()->aspect();
        return $this->_save();
    }

    public function crop()
    {
        if (!$this->isCropable()) return $this;
        $cropField = $this->field . '_crop';
        $this->imagine->crop(new Point($this->model->{$cropField}['x'], $this->model->{$cropField}['y']),new Box($this->model->{$cropField}['width'], $this->model->{$cropField}['height']));
        //$this->_imagine = Imagine::crop($this->tempName, $this->model->{$cropField}['width'], $this->model->{$cropField}['height'], [$this->model->{$cropField}['x'], $this->model->{$cropField}['y']]);
        return $this;
    }

    public function isCropable()
    {
        Yii::trace($this->model->attributes);
        return isset($this->model->{$this->field . '_crop'});
    }

    /**
     * 调整图片尺寸
     * @return static
     */
    public function resize()
    {
        $ratio = $this->resizeRatio;
        if ($ratio > 0 && $ratio < 1) {
            $box = $this->imagine->getSize()->scale($ratio);
            $this->imagine->resize($box);
        }
        return $this;
    }

    /**
     * 调整图片宽高比例
     * @return static
     */
    public function aspect()
    {
        $aspectRatio = $this->aspectRatio;
        if($aspectRatio<=0) return $this;
        $size = $this->imagine->getSize();
        $imageWidth = $size->getWidth();
        $imageHeight = $size->getHeight();
        $imageAspect = $imageWidth/$imageHeight;
        if(intval($imageAspect*100000)==intval($aspectRatio*100000)) return $this;
        if($imageAspect>$aspectRatio) $size = $size->widen($imageHeight*$aspectRatio);
        else  $size = $size->heighten($imageWidth/$aspectRatio);
        $this->imagine->thumbnail($size,ManipulatorInterface::THUMBNAIL_OUTBOUND);
        return $this;
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

    public function getResizeRatio()
    {
        if ($this->_resizeRatio === null) {
            $imageWidth = $this->imagine->getSize()->getWidth();
            if ($imageWidth > $this->maxWidth) $this->_resizeRatio = $this->maxWidth / $imageWidth;
        }
        return $this->_resizeRatio;
    }

    public function setResizeRatio($ratio)
    {
        $this->_resizeRatio = $ratio;
    }

    /**
     * 纵横比
     * @return float
     */
    public function getAspectRatio()
    {
        if ($this->_aspectRatio === null) {
            $this->_aspectRatio = floatval($this->getConfig('aspectRatio', 0));
        }
        if (is_array($this->_aspectRatio)){
            if(isset($this->_aspectRatio[0],$this->_aspectRatio[1])&&$this->_aspectRatio[1]>0)
                $this->_aspectRatio=$this->_aspectRatio[0]/$this->_aspectRatio[1];
            else $this->_aspectRatio = 0;
        }
        return $this->_aspectRatio = abs($this->_aspectRatio);
    }

    public function setAspectRatio($ratio)
    {
        $this->_aspectRatio = $ratio;
    }

    public function getMaxWidth()
    {
        if ($this->_maxWidth === null) {
            $this->_maxWidth = intval($this->getConfig('maxWidth', 2048));
        }
        return $this->_maxWidth;
    }

    public function setMaxWidth($size)
    {
        $this->_maxWidth = $size;
    }

    /*public function getMaxHeight()
    {
        if ($this->_maxHeight === null) {
            $this->_maxHeight = intval($this->getConfig('maxHeight', 1080));
        }
        return $this->_maxHeight;
    }

    public function setMaxHeight($size)
    {
        $this->_maxHeight = $size;
    }*/

    public function getSaveRaw()
    {
        if ($this->_saveRaw === null) $this->_saveRaw = $this->getConfig('saveRaw', false);
        return $this->_saveRaw;
    }

    public function setSaveRaw($config)
    {
        $this->_saveRaw = $config;
    }

    public function getQualityConfig()
    {
        if ($this->_qualityConfig === null) $this->_qualityConfig = $this->getConfig('quality', 80);
        return $this->_qualityConfig;
    }

    public function setQualityConfig($config = 60)
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
        if (empty($this->_imagine)) $this->_imagine = Imagine::getImagine()->open($this->tempName);
        return $this->_imagine;
    }


    /**
     * 判断上传文件是否为图片类型
     * @return bool
     */
    public function isImage()
    {
        if (function_exists('exif_imagetype')) {
            $exifImageType = exif_imagetype($this->tempName);
            if ($exifImageType == IMAGETYPE_BMP || $exifImageType == IMAGETYPE_GIF || $exifImageType == IMAGETYPE_JPEG || $exifImageType == IMAGETYPE_PNG) {
                return true;
            }
        } else {
            if ($this->fileExt != false && in_array($this->fileExt,$this->_imageExt)) return true;
        }
        $this->addError('上传文件非图片文件');
        return false;
    }

    private function _saveRaw()
    {
        return Yii::$app->storage->writeStream($this->path . $this->fileName, fopen($this->tempName, 'r+'));
    }

    private function _save()
    {
        //return Yii::$app->storage->writeStream($this->path . $this->fileName, fopen($this->tempName, 'r+'));
        return Yii::$app->storage->write($this->uri,
            $this->imagine->get($this->fileExt, ['quality' => $this->qualityConfig]));
    }

}