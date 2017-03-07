<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "{{%model_attribute}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $status
 * @property string $name
 * @property string $label
 * @property integer $sort
 * @property string $data_type
 * @property string $input_type
 * @property string $default_value
 * @property integer $length
 * @property integer $is_key
 * @property integer $required
 * @property string $extra
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class ModelAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%model_attribute}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'name'], 'required'],
            [['model_id', 'status', 'sort', 'length', 'is_key', 'required', 'created_at', 'updated_at'], 'integer'],
            [['name', 'label', 'data_type', 'input_type', 'default_value'], 'string', 'max' => 255],
            [['extra', 'description'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'model_id' => Yii::t('common', 'Model ID'),
            'status' => Yii::t('common', '状态0新建1已审核'),
            'name' => Yii::t('common', 'Name'),
            'label' => Yii::t('common', '标签'),
            'sort' => Yii::t('common', 'Sort'),
            'data_type' => Yii::t('common', '数据类型'),
            'input_type' => Yii::t('common', '输入类型'),
            'default_value' => Yii::t('common', '默认值'),
            'length' => Yii::t('common', '数据长度0不限制'),
            'is_key' => Yii::t('common', 'Is Key'),
            'required' => Yii::t('common', '必须'),
            'extra' => Yii::t('common', '额外数据，选择列表的选择项目（英文逗号分隔）'),
            'description' => Yii::t('common', 'Description'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
