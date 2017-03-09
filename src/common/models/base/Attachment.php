<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property string $id
 * @property integer $status
 * @property string $user_id
 * @property integer $category
 * @property integer $type
 * @property string $name
 * @property string $description
 * @property integer $permission
 * @property string $path
 * @property string $filename
 * @property string $file_ext
 * @property string $file_size
 * @property integer $thumb
 * @property string $mime
 * @property string $extra
 * @property integer $reference
 * @property string $created_at
 * @property string $updated_at
 */
class Attachment extends \yii\db\ActiveRecord
{
    const STATUS_CREATED = 0;
    const STATUS_DELETED = -1;
    const STATUS_APPROVED = -1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'user_id', 'category', 'type', 'permission', 'file_size', 'thumb', 'reference', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'path', 'filename', 'file_ext', 'mime'], 'string', 'max' => 255],
            [['extra'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'status' => Yii::t('common', '状态0正常/-1删除'),
            'user_id' => Yii::t('common', 'User ID'),
            'category' => Yii::t('common', '附件分类'),
            'type' => Yii::t('common', '文件类型：0未知'),
            'name' => Yii::t('common', '附件名称'),
            'description' => Yii::t('common', '附件描述'),
            'permission' => Yii::t('common', '权限'),
            'path' => Yii::t('common', '文件路径，包含文件名'),
            'filename' => Yii::t('common', 'Filename'),
            'file_ext' => Yii::t('common', '文件后缀'),
            'file_size' => Yii::t('common', '文件大小'),
            'thumb' => Yii::t('common', '按位存储缩略图'),
            'mime' => Yii::t('common', '文件MIME类型'),
            'extra' => Yii::t('common', '图片宽高等'),
            'reference' => Yii::t('common', '引用数量，为0的可能会被删除'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
