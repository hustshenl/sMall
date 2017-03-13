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
use common\components\base\HttpRequest;


class Download extends BaseAttachment
{
    private $_httpRequest;

    public function init()
    {
        parent::init();
        $response = $this->httpRequest->send();
        if($response->isOk){
            // TODO 保存文件
            $this->fileSize = strlen($response->content);
        }else{
            $this->addError('附件下载出错，Http status code:'.$response->statusCode);
        }
    }

    public function save()
    {
        return Yii::$app->storage->write($this->path . $this->fileName, $this->httpRequest->response->content);
        /*return Yii::$app->storage->write($this->path . $this->fileName,
            $this->imagine->get('jpeg', ['quality' => static::getQualityConfig($this->category)]));*/
    }

    public function setHttpRequest($httpRequest)
    {
        $this->_httpRequest = $httpRequest;
    }

    public function getHttpRequest()
    {
        if(!$this->_httpRequest) throw new BadRequestHttpException('HttpRequest 没有配置！');
        return $this->_httpRequest;
    }


}