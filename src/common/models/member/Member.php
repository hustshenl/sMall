<?php

namespace common\models\member;

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
 * @property string $qq
 * @property string $email
 * @property string $phone
 * @property string $weibo
 * @property string $address
 * @property integer $postcode
 * @property integer $scores
 * @property integer $grade
 * @property integer $credit
 * @property integer $vip
 * @property integer $vip_scores
 * @property integer $vip_expires
 * @property integer $role
 * @property integer $gender
 * @property string $district
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $language
 * @property string $avatar
 * @property string $signature
 * @property string $remark
 * @property integer $register_ip
 * @property integer $login_at
 * @property integer $login_ip
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord
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
            [['status', 'postcode', 'scores', 'grade', 'credit', 'vip', 'vip_scores', 'vip_expires', 'role', 'gender', 'register_ip', 'login_at', 'login_ip', 'created_at', 'updated_at'], 'integer'],
            [['username', 'nickname', 'identity', 'identity_sn', 'qq', 'email', 'weibo', 'address', 'avatar'], 'string', 'max' => 255],
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
            'qq' => Yii::t('common', 'Qq'),
            'email' => Yii::t('common', 'Email'),
            'phone' => Yii::t('common', 'Phone'),
            'weibo' => Yii::t('common', 'Weibo'),
            'address' => Yii::t('common', 'Address'),
            'postcode' => Yii::t('common', 'Postcode'),
            'scores' => Yii::t('common', 'Scores'),
            'grade' => Yii::t('common', 'Grade'),
            'credit' => Yii::t('common', 'Credit'),
            'vip' => Yii::t('common', 'Vip'),
            'vip_scores' => Yii::t('common', 'Vip Scores'),
            'vip_expires' => Yii::t('common', 'Vip Expires'),
            'role' => Yii::t('common', 'Role'),
            'gender' => Yii::t('common', 'Gender'),
            'district' => Yii::t('common', 'District'),
            'city' => Yii::t('common', 'City'),
            'province' => Yii::t('common', 'Province'),
            'country' => Yii::t('common', 'Country'),
            'language' => Yii::t('common', 'Language'),
            'avatar' => Yii::t('common', 'Avatar'),
            'signature' => Yii::t('common', 'Signature'),
            'remark' => Yii::t('common', 'Remark'),
            'register_ip' => Yii::t('common', 'Register Ip'),
            'login_at' => Yii::t('common', 'Login At'),
            'login_ip' => Yii::t('common', 'Login Ip'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return MemberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemberQuery(get_called_class());
    }
}
