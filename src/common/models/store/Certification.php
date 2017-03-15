<?php

namespace common\models\store;

use common\components\attachment\UploadImage;
use common\models\system\Model;
use Yii;

/**
 * This is the model class for table "{{%certification}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property integer $category
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property integer $price
 * @property integer $deposit
 * @property integer $expires_in
 * @property integer $model_id
 * @property integer $sort
 * @property string $reference
 * @property string $created_at
 * @property string $updated_at
 */
class Certification extends \yii\db\ActiveRecord
{
    //const TYPE_STORE_SERVICE = 0;
    //const TYPE_STORE_JOIN = 1;

    const CATEGORY_STORE_SERVICE = 0;
    const CATEGORY_STORE_JOIN = 1;

    public static $categories = [
        self::CATEGORY_STORE_SERVICE => '店铺服务认证',
        self::CATEGORY_STORE_JOIN => '店铺入驻认证',
    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%certification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'type', 'category', 'price', 'deposit', 'expires_in', 'sort', 'model_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'model_id'], 'required'],
            [['name', 'reference','icon'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2048],
            [['status', 'type', 'category', 'price', 'deposit', 'expires_in'], 'default', 'value' => 0],
            [['sort'], 'default', 'value' => 999],
            [['formPrice', 'formDeposit', 'formExpiresIn',], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'status' => Yii::t('common', '状态'),
            'type' => Yii::t('common', '类型'),
            'category' => Yii::t('common', '分类'),
            'name' => Yii::t('common', '认证名称'),
            'description' => Yii::t('common', '认证描述'),
            'icon' => Yii::t('common', '图标'),
            'price' => Yii::t('common', '认证价格'),
            'deposit' => Yii::t('common', '保证金'),
            'expires_in' => Yii::t('common', '有效期'),
            'model_id' => Yii::t('common', '认证表单'),
            'sort' => Yii::t('common', '排序值'),
            'reference' => Yii::t('common', '引用页地址'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    public function load($data, $formName = null)
    {
        if (!parent::load($data, $formName)) {
            return false;
        }
        return true;
    }

    /**
     * 上传图片，需要手动调用
     * @return bool
     */
    public function upload(){
        //  TODO 文件上传处理方案,
        $imageUpload = new UploadImage(['model' => $this, 'field' => 'icon']);
        if (!$imageUpload->save()) return false;
        $this->icon = $imageUpload->uri;
        return true;
    }


    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'model_id']);
    }

    public function getFormPrice()
    {
        return $this->price === null ? 0 : Yii::$app->formatter->asPrice($this->price, 2, '');
    }

    public function setFormPrice($value)
    {
        $this->price = Yii::$app->formatter->asPriceValue($value);
    }

    public function getFormDeposit()
    {
        return $this->deposit === null ? 0 : Yii::$app->formatter->asPrice($this->deposit, 2, '');
    }

    public function setFormDeposit($value)
    {
        $this->deposit = Yii::$app->formatter->asPriceValue($value);
    }

    public function getFormExpiresIn()
    {
        if ($this->expires_in <= 0) return '永久';
        return Yii::$app->formatter->asAbsoluteDuration($this->expires_in);
    }

    public function setFormExpiresIn($value)
    {
        $this->expires_in = in_array($value, ['永久', '长期', '一直有效'])
            ? 0 : Yii::$app->formatter->asDurationValue($value);
    }
}
