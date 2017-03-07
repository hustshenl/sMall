<?php

namespace common\models\system;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%model}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
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
    const TYPE_MODEL=0;
    const TYPE_FORM=1;
    public static $types = [
        self::TYPE_MODEL=>'模型',
        self::TYPE_FORM=>'表单',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%model}}';
    }

    public function behaviors()
    {
        $behaviors =  parent::behaviors();
        //$behaviors[] = SlugBehavior::className();
        $behaviors[] = TimestampBehavior::className();
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'type', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['name','type','identifier'], 'required'],
            [['identifier'], 'unique'],
            [['name', 'identifier', 'table'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2048],
            [['sort'], 'default', 'value' => 999],
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
            'status' => Yii::t('common', '状态'),
            'identifier' => Yii::t('common', '唯一标识'),
            'type' => Yii::t('common', '模型类型'),
            'table' => Yii::t('common', '数据表名'),
            'description' => Yii::t('common', 'Description'),
            'sort' => Yii::t('common', '排序值'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
