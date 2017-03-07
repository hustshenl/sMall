<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "{{%model_data}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $data
 * @property string $memo
 * @property string $created_at
 * @property string $updated_at
 */
class ModelData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%model_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'data', 'created_at', 'updated_at'], 'required'],
            [['id', 'model_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
            [['memo'], 'string', 'max' => 2048],
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
            'data' => Yii::t('common', '表单数据'),
            'memo' => Yii::t('common', '备忘信息'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
