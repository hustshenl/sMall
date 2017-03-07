<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "{{%model}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $type
 * @property string $table
 * @property string $description
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 */
class Model extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'type', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'required'],
            [['name', 'table'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'status' => Yii::t('common', '状态0禁用1启用'),
            'type' => Yii::t('common', '模型类型0模型，1表单'),
            'table' => Yii::t('common', '数据表名'),
            'description' => Yii::t('common', 'Description'),
            'sort' => Yii::t('common', '排序值'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
