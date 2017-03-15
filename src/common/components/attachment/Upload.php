<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2017/3/13
 * Time: 0:15
 */

namespace common\components\attachment;


use yii\base\Component;
use yii\web\UploadedFile;
use yii\web\BadRequestHttpException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii;
use yii\helpers\ArrayHelper;
/**
 * Class Attachment
 * 处理附件上传任务，不支持多文件同时上传
 * @package common\components
 * @property integer $maxSize
 */

class Upload extends BaseAttachment
{
    public $field='file';

    private $_maxSize;


    public function init()
    {
        parent::init();
        $uploadFile = UploadedFile::getInstance($this->model, $this->field);
        if($uploadFile ===null ) return;
        $this->tempName = $uploadFile->tempName;
        $this->fileSize = $uploadFile->size;
    }


    /**
     * 判断文件大小是否超限
     * @return bool
     */
    public function isOutOfSize()
    {
        if ($this->maxSize>0&&$this->fileSize > $this->maxSize) {
            $this->model->addError($this->field, sprintf('文件太大,请上传小于 %s 的文件', Yii::$app->formatter->asShortSize($this->maxSize)));
            $this->addError('文件大小超过限制');
            return true;
        }
        return false;
    }

    public function save()
    {
        return Yii::$app->storage->writeStream($this->path . $this->fileName, fopen($this->tempName, 'r+'));
        /*return Yii::$app->storage->write($this->path . $this->fileName,
            $this->imagine->get('jpeg', ['quality' => static::getQualityConfig($this->category)]));*/
    }


    public function getMaxSize()
    {
        if($this->_maxSize === null){
            $maxSize = $this->getConfig('maxSize',2048*1024);
            $this->_maxSize = Yii::$app->formatter->asSizeValue($maxSize);
        }
        return $this->_maxSize;
    }
    public function setMaxSize($size)
    {
        $this->_maxSize = $size;
    }


}