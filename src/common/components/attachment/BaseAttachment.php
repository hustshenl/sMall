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
 * 处理附件上传任务
 * @package common\components
 * @property HttpRequest $httpRequest
 * @property ActiveRecord $model
 * @property AttachmentModel $attachment
 * @property string $tempExt
 * @property string $tempName
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

    public $maxSize=false;
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
    private $_path;
    private $_fileName=false;
    private $_fileExt;
    private $_fileSize;
    private $_errors=[];

    public function init()
    {
        parent::init();
    }

    /**
     * 判断文件大小是否超限
     * @return bool
     */
    public function isOutOfSize()
    {
        $maxSize = $this->maxSize===false?ArrayHelper::getValue(Yii::$app->params['upload'],'maxSize',2048*1024):$this->maxSize;
        $maxSize = Yii::$app->formatter->asSizeValue($maxSize);
        if ($maxSize>0&&$this->fileSize > $maxSize) {
            $this->model->addError($this->field, sprintf('文件太大,请上传小于 %s 的文件', Yii::$app->formatter->asShortSize($maxSize)));
            $this->addError('文件大小超过限制');
            return true;
        }
        return false;
    }

    abstract public function save();

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
            $_randName = time() .Yii::$app->security->generateRandomString(16);
            $fileName = $_randName . "." . $ext;
        } while (Yii::$app->storage->has(rtrim($path,'/'). '/' . $fileName));
        return $fileName;
    }

    public static function getBasePath($category)
    {
        if(!isset(Yii::$app->params['upload'][$category]['path'])) throw new yii\base\InvalidConfigException('配置有误');
        return Yii::$app->params['upload'][$category]['path'];
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