<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/5 21:02
 * @Description:
 */

namespace common\components\base;

use common\models\base\Attachment as AttachmentModel;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii;

/**
 * Class Attachment
 * 处理封面相关事务
 * 封面处理流程：上传封面，将封面保存到图片数据库，状态为待审核，将漫画封面状态设置为待审核
 * 封面审核通过后将封面信息写入到漫画表
 * @package common\components
 * @property ActiveRecord $model
 * @property AttachmentModel $attachment
 * @property array $errors
 * @property string $firstError
 */
class Attachment extends Component
{

    const EVENT_AFTER_UPLOAD = 'afterUpload';

    public $category = 'cover';
    public $field = 'attachment';
    /**
     * @var $_model ActiveRecord
     */
    public $_model;
    /**
     * @var $_attachment AttachmentModel
     */
    private $_attachment;
    public $id;

    private $_errors = [];

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

    public function afterCreate()
    {
        $this->approve();
        return true;
    }


    public function approve()
    {
        if (!$this->attachment || !$this->isApprovable()) return false;
        $this->attachment->status = AttachmentModel::STATUS_APPROVED;
        if ($res = $this->attachment->save()) {
            $this->trigger(static::EVENT_AFTER_APPROVE, new Event());
        }
        return $res;
        //return $this->attachment->save();
    }

    public function remove()
    {
        if (!$this->model || !$this->isRemovable()) return false;
        $this->model->cover = '';
        return $this->model->save();
    }

    public function isRemovable()
    {
        return true;
    }

    public function removeAttachment()
    {
        if (!$this->model || !$this->attachment || !$this->isAttachmentRemovable()) return false;
        //删除图片
        $this->attachment->status = AttachmentModel::STATUS_DELETED;
        return $this->attachment->save() && ($this->model->cover != $this->attachment->url || $this->remove());
        //if($this->model->cover == $this->attachment->url) $this->remove();
    }

    public function isAttachmentRemovable()
    {
        return true;
    }

    public function update()
    {

    }

    /**
     *
     */
    public function delete()
    {

    }


    public function getErrors()
    {
        return $this->_errors;
    }

    public function getFirstError()
    {
        $errors = $this->errors;
        return count($errors) > 0 ? reset($errors) : '';
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

    public function setModel($model)
    {
        $this->_model = $model;
    }

    public function getModel()
    {
        if (!$this->_model) throw new BadRequestHttpException('Model 没有配置！');
        return $this->_model;
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


    /**
     * Finds the Attachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttachmentModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AttachmentModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}