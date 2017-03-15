<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/5 21:02
 * @Description:
 */

namespace common\components\attachment;

use yii\base\Component;
use yii\web\BadRequestHttpException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii;
use yii\helpers\ArrayHelper;
use common\models\base\Attachment as AttachmentModel;
use common\components\base\HttpRequest;


/**
 * Class Attachment
 * 处理附件任务
 * @package common\components
 * @property HttpRequest $httpRequest
 * @property ActiveRecord $model
 * @property AttachmentModel $attachment
 * @property string $tempExt
 * @property string $tempName
 * @property array $config
 * @property string $uri
 * @property string $path
 * @property string $fileName
 * @property string $fileExt
 * @property integer $fileSize
 * @property array $errors
 * @property string $firstError
 */
abstract class BaseAttachment extends Component {

    const CATEGORY_COMMON = 'common';
    const CATEGORY_GOODS = 'goods';
    const CATEGORY_MEMBER = 'member';
    const CATEGORY_ARTICLE = 'article';
    const CATEGORY_BLOCK = 'block';
    const CATEGORY_STORE = 'store';
    const CATEGORY_TEMP = 'temp';

    public $category = self::CATEGORY_COMMON;

    private $_tempName;
    private $_tempExt;
    /**
     * @var $_model ActiveRecord
     */
    protected $_model;
    /**
     * @var $_attachment AttachmentModel
     */
    private $_attachment;
    private $_config;

    private $_uri;
    private $_path;
    private $_fileName=false;
    private $_fileExt;
    private $_fileSize;
    private $_errors=[];

    public function init()
    {
        parent::init();
    }


    abstract public function save();

    public function getConfig($item,$default=null)
    {
        if($this->_config === null) $this->_config =  ArrayHelper::getValue(Yii::$app->params,['attachment',$this->category],[]);
        if($item === null) return $this->_config;
        $attachmentConfig = ArrayHelper::getValue(Yii::$app->params,'attachment',[]);
        return ArrayHelper::getValue($this->_config,$item,ArrayHelper::getValue($attachmentConfig,$item,$default));
    }
    public function setConfig($config)
    {
        $this->_config  = $config;
    }

    public function getTempName()
    {
        if(!$this->_tempName) throw new BadRequestHttpException('附件临时文件名为空 没有配置！');
        return $this->_tempName;
    }
    public function setTempName($tempName)
    {
        $this->_tempName = $tempName;
    }
    public function getTempExt()
    {
        return $this->_tempExt ? $this->_tempExt : $this->_tempExt = strtolower(pathinfo($this->tempName, PATHINFO_EXTENSION));
    }
    public function setTempExt($tempExt)
    {
        $this->_tempExt = $tempExt;
    }

    public function getFileName()
    {
        if(!$this->_fileName) $this->_fileName = $this->_generateFileName($this->path,$this->fileExt);
        return $this->_fileName;
    }
    public function getUri()
    {
        if(!$this->_uri) $this->_uri = $this->path.$this->fileName.'.'.$this->fileExt;
        return $this->_uri;
    }
    public function clearFileName()
    {
        $this->_fileName = false;
    }

    public function getFileSize()
    {
        if(!$this->_fileSize) throw new BadRequestHttpException('无法确定附件大小！');
        return $this->_fileSize ? $this->_fileSize : $this->_fileSize = $this->instance->getExtension();
    }
    public function setFileSize($fileSize)
    {
        $this->_fileSize = $fileSize;
    }
    public function getFileExt()
    {
        return $this->_fileExt ? $this->_fileExt : $this->_fileExt = ($this->tempExt?$this->tempExt:'jpg');
    }
    public function getPath()
    {
        if(!$this->_path){
            $this->_path = $this->_getBasePath();
            $this->_path .= date('Ym', time()).'/';
        }
        return $this->_path;
    }
    public function setPath($path)
    {
        $this->_path = $path;
    }

    public function setAttachment($attachment)
    {
        $this->_attachment = $attachment;
    }

    public function getAttachment()
    {
        if (!$this->_attachment) throw new BadRequestHttpException('Attachment 模型没有配置！');
        return $this->_attachment;
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

    /**
     * 根据路径和后缀生成文件名
     * @param $path
     * @param $ext
     * @return string
     */
    protected function _generateFileName($path,$ext='jpg')
    {
        do {
            $_randName = time() .'_'.Yii::$app->security->generateRandomString(16);
            $fileName = $_randName . "." . $ext;
        } while (Yii::$app->storage->has(rtrim($path,'/'). '/' . $fileName));
        return $_randName;
    }

    private function _getBasePath()
    {
        $path = $this->getConfig('path');//ArrayHelper::getValue(Yii::$app->params,['attachment',$this->category,'path']);
        if($path===null) throw new yii\base\InvalidConfigException('配置有误');
        return $path;
    }

    /**
     * Finds the Attachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttachmentModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findAttachment($id)
    {
        if (($model = AttachmentModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}