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

class Upload extends BaseAttachment
{
    public $field='file';

    public function init()
    {
        parent::init();
        $uploadFile = UploadedFile::getInstance($this->model, $this->field);
        $this->tempName = $uploadFile->tempName;
        $this->fileSize = $uploadFile->size;
    }

    public function save()
    {
        return Yii::$app->storage->writeStream($this->path . $this->fileName, fopen($this->tempName, 'r+'));
        /*return Yii::$app->storage->write($this->path . $this->fileName,
            $this->imagine->get('jpeg', ['quality' => static::getQualityConfig($this->category)]));*/
    }


}