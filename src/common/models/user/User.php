<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $status
 * @property string $username
 * @property string $nickname
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $access_token
 * @property string $identity
 * @property string $identity_sn
 * @property string $email
 * @property string $phone
 * @property integer $credit
 * @property integer $point
 * @property integer $coin
 * @property integer $scores
 * @property integer $grade
 * @property integer $role
 * @property string $qq
 * @property string $weibo
 * @property integer $gender
 * @property string $avatar
 * @property string $signature
 * @property string $address
 * @property integer $postcode
 * @property string $district
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $language
 * @property string $remark
 * @property integer $register_ip
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'credit', 'point', 'coin', 'scores', 'grade', 'role', 'gender', 'postcode', 'register_ip', 'created_at', 'updated_at'], 'integer'],
            [['username', 'nickname', 'identity', 'identity_sn', 'email', 'qq', 'weibo', 'avatar', 'address'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'phone', 'district', 'city', 'province', 'country', 'language'], 'string', 'max' => 64],
            [['password_reset_token', 'access_token'], 'string', 'max' => 128],
            [['signature', 'remark'], 'string', 'max' => 2048],
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
            'username' => Yii::t('common', 'Username'),
            'nickname' => Yii::t('common', 'Nickname'),
            'auth_key' => Yii::t('common', 'Auth Key'),
            'password_hash' => Yii::t('common', 'Password Hash'),
            'password_reset_token' => Yii::t('common', 'Password Reset Token'),
            'access_token' => Yii::t('common', 'Access Token'),
            'identity' => Yii::t('common', 'Identity'),
            'identity_sn' => Yii::t('common', 'Identity Sn'),
            'email' => Yii::t('common', 'Email'),
            'phone' => Yii::t('common', 'Phone'),
            'credit' => Yii::t('common', '账户余额'),
            'point' => Yii::t('common', '商城点数，类似天猫积分/京东京豆'),
            'coin' => Yii::t('common', '商城币，类似天猫点券/Q币之类，可充值不可提现'),
            'scores' => Yii::t('common', '等级积分'),
            'grade' => Yii::t('common', '用户等级'),
            'role' => Yii::t('common', 'Role'),
            'qq' => Yii::t('common', 'Qq'),
            'weibo' => Yii::t('common', 'Weibo'),
            'gender' => Yii::t('common', 'Gender'),
            'avatar' => Yii::t('common', 'Avatar'),
            'signature' => Yii::t('common', 'Signature'),
            'address' => Yii::t('common', 'Address'),
            'postcode' => Yii::t('common', 'Postcode'),
            'district' => Yii::t('common', 'District'),
            'city' => Yii::t('common', 'City'),
            'province' => Yii::t('common', 'Province'),
            'country' => Yii::t('common', 'Country'),
            'language' => Yii::t('common', 'Language'),
            'remark' => Yii::t('common', 'Remark'),
            'register_ip' => Yii::t('common', 'Register Ip'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
