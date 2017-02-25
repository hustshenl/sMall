<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%seller}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property string $username
 * @property integer $user_id
 * @property integer $store_id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $name
 * @property string $avatar
 * @property string $signature
 * @property string $phone
 * @property string $department
 * @property string $position
 * @property string $permission
 * @property string $remark
 * @property integer $created_at
 * @property integer $updated_at
 */
class Seller extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seller}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'user_id', 'store_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'name', 'avatar', 'signature', 'department', 'position'], 'string', 'max' => 255],
            [['auth_key', 'phone'], 'string', 'max' => 64],
            [['permission', 'remark'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'status' => Yii::t('common', 'Status'),
            'username' => Yii::t('common', '商家用户名'),
            'user_id' => Yii::t('common', '对应的子主账户ID'),
            'store_id' => Yii::t('common', '店铺ID'),
            'auth_key' => Yii::t('common', 'Auth Key'),
            'password_hash' => Yii::t('common', 'Password Hash'),
            'name' => Yii::t('common', '姓名'),
            'avatar' => Yii::t('common', 'Avatar'),
            'signature' => Yii::t('common', 'Signature'),
            'phone' => Yii::t('common', 'Phone'),
            'department' => Yii::t('common', '部门'),
            'position' => Yii::t('common', '岗位'),
            'type' => Yii::t('common', '账户类型，主账户/子账户'),
            'permission' => Yii::t('common', '权限'),
            'remark' => Yii::t('common', '备注信息'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return SellerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SellerQuery(get_called_class());
    }
}
