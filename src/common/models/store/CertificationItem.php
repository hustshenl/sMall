<?php

namespace common\models\store;

use Yii;

/**
 * This is the model class for table "{{%certification_item}}".
 *
 * @property integer $id
 * @property integer $certification_id
 * @property integer $status
 * @property integer $type
 * @property string $name
 * @property string $label
 * @property integer $required
 * @property string $notice
 * @property string $items
 * @property integer $sort
 */
class CertificationItem extends \yii\db\ActiveRecord
{

    const TYPE_INPUT_TEXT = 0;
    const TYPE_INPUT_TEXTAREA = 1;
    const TYPE_INPUT_FILE = 2;
    const TYPE_INPUT_IMAGE = 3;
    const TYPE_INPUT_SELECT = 4;

    public static $types = [
        self::TYPE_INPUT_TEXT=>'单行文本',
        self::TYPE_INPUT_TEXTAREA=>'多行文本',
        self::TYPE_INPUT_FILE=>'文件',
        self::TYPE_INPUT_IMAGE=>'图片',
        self::TYPE_INPUT_SELECT=>'下拉选择',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%certification_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','label','type'], 'required'],
            [['certification_id', 'status', 'type', 'required', 'sort'], 'integer'],
            [['name', 'label'], 'string', 'max' => 255],
            [['notice', 'items'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'certification_id' => Yii::t('common', '认证ID'),
            'status' => Yii::t('common', '状态'),
            'type' => Yii::t('common', '类型'),
            'name' => Yii::t('common', '项目名称'),
            'label' => Yii::t('common', '项目标签'),
            'required' => Yii::t('common', '必须'),
            'notice' => Yii::t('common', '提示信息'),
            'items' => Yii::t('common', '选项列表'),
            'sort' => Yii::t('common', '排序值'),
        ];
    }
}
