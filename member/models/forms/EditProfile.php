<?php
namespace member\models\forms;

use common\models\access\User;
use yii\base\Model;
use yii;

/**
 * EditProfile form
 */
class EditProfile extends Model
{
    public $id;
    public $username;
    public $nickname;
    public $identity;
    public $identity_sn;
    public $qq;
    public $weibo;
    public $phone;
    public $remark;
    public $email;
    public $signature;
    public $address;
    public $postcode;
    public $gender;
    public $province;
    public $city;
    public $district;
    public $isNewRecord = false;

    /**
     * @param array $config
     * @param bool $item
     */
    public function __construct($config = [], $item = false)
    {

        parent::__construct($config);

        if ($item) {
            $this->attributes = $item;
            if ($this->postcode == 0) $this->postcode = '';
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender'], 'integer'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            //['username', 'unique', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            //['email', 'unique', 'message' => 'This email address has already been taken.'],

            //['password', 'required'],

            [['nickname', 'identity', 'identity_sn', 'qq', 'weibo', 'phone', 'remark', 'signature', 'address', 'postcode', 'gender', 'province', 'city', 'district'], 'string'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'username' => Yii::t('common', 'Username'),
            'nickname' => Yii::t('common', 'Nickname'),
            'identity' => Yii::t('common', 'Identity'),
            'identity_sn' => Yii::t('common', 'Identity Sn'),
            'qq' => Yii::t('common', 'QQ'),
            'weibo' => Yii::t('common', 'Weibo'),
            'phone' => Yii::t('common', 'Phone'),
            'remark' => Yii::t('common', 'Remark'),
            'email' => Yii::t('common', 'Email'),
            'signature' => Yii::t('common', 'Signature'),
            'address' => Yii::t('common', 'Address'),
            'postcode' => Yii::t('common', 'Postcode'),
            'gender' => Yii::t('common', 'Gender'),
            'province' => Yii::t('common', 'Province'),
            'city' => Yii::t('common', 'City'),
            'district' => Yii::t('common', 'District'),
        ];
    }

    /**
     * Signs user up.
     * @param bool|false $useOldPassword
     * @return User|false the saved model or null if saving fails
     */

    public function update($validatePassword = true)
    {
        if ($this->validate()) {
            /**
             * $user User
             */
            $user = User::findOne($this->id);
            $user->scenario = 'edit_profile';
            if ($user->load((array)$this->attributes, '') && $user->save()) {
                return $user;
            }
        }

        return false;
    }
}
