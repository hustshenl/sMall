<?php

namespace common\models\system;

use Yii;
use yii\behaviors\TimestampBehavior;


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
    const DATA_TYPE_INT = 0;
    const DATA_TYPE_STRING = 1;
    const DATA_TYPE_ENUM = 2;

    public static $dataTypes = [
        self::DATA_TYPE_INT=>'整型',
        self::DATA_TYPE_STRING=>'字符串',
        self::DATA_TYPE_ENUM=>'枚举',
    ];

    const INPUT_TYPE_TEXT = 0;
    const INPUT_TYPE_TEXTAREA = 1;
    const INPUT_TYPE_PASSWORD = 2;
    const INPUT_TYPE_SELECT = 3;
    const INPUT_TYPE_CHECKBOX = 4;
    const INPUT_TYPE_SWITCH= 5;
    const INPUT_TYPE_FILE = 6;

    public static $inputTypes = [
        self::INPUT_TYPE_TEXT => '单行文本',
        self::INPUT_TYPE_TEXTAREA => '多行文本',
        self::INPUT_TYPE_PASSWORD => '密码框',
        self::INPUT_TYPE_SELECT => '下拉选择',
        self::INPUT_TYPE_CHECKBOX => '复选框',
        self::INPUT_TYPE_SWITCH => '开关',
        self::INPUT_TYPE_FILE => '文件',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%model_attribute}}';
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
            [['model_id', 'name'], 'required'],
            ['name', 'unique', 'targetAttribute' => ['name','model_id'],'message'=> Yii::t('yii', '{attribute} "{value}" has already been taken.')],
            [['model_id', 'status', 'sort', 'length', 'is_key', 'required', 'created_at', 'updated_at'], 'integer'],
            [['name', 'label', 'data_type', 'input_type', 'default_value'], 'string', 'max' => 255],
            [['extra', 'description'], 'string', 'max' => 2048],
            [['length', 'sort'], 'default', 'value' => 255],
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
            'status' => Yii::t('common', '状态'),
            'name' => Yii::t('common', 'Name'),
            'label' => Yii::t('common', '标签'),
            'sort' => Yii::t('common', 'Sort'),
            'data_type' => Yii::t('common', '数据类型'),
            'input_type' => Yii::t('common', '输入类型'),
            'default_value' => Yii::t('common', '默认值'),
            'length' => Yii::t('common', '数据长度'),
            'is_key' => Yii::t('common', '是否主键'),
            'required' => Yii::t('common', '必须'),
            'extra' => Yii::t('common', '额外数据'),
            'description' => Yii::t('common', 'Description'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
