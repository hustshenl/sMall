<?php
namespace common\models\access;

use common\behaviors\IPBehavior;
use yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property integer $status
 * @property string $username
 * @property string $nickname
 * @property string $auth_key
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
 * @property string $password write-only password
 * @property string $password_hash write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_FORBIDDEN = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_USER = 0x1;
    const ROLE_SELLER = 0x100;
    const ROLE_SELLER_SUB = 0x101;
    const ROLE_ADMIN = 0x1000;
    const ROLE_SYSTEM = 0x10000;


    const CLIENT_DESKTOP = 0;
    const CLIENT_WAP = 1;
    const CLIENT_ANDROID = 2;
    const CLIENT_IOS = 3;

    public static $clients = [
        self::CLIENT_DESKTOP=>'desktop',
        self::CLIENT_WAP=>'wap',
        self::CLIENT_ANDROID=>'android',
        self::CLIENT_IOS=>'ios',
    ];
    public static $clientsName = [
        self::CLIENT_DESKTOP=>'桌面网页',
        self::CLIENT_WAP=>'移动网页',
        self::CLIENT_ANDROID=>'安卓客户端',
        self::CLIENT_IOS=>'iOS客户端',
    ];



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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class'=>IPBehavior::className(),
                'attributes'=>[
                    yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['register_ip'],
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_FORBIDDEN]],
            [['nickname','identity','identity_sn','qq','weibo','phone','remark','signature','address','postcode','gender','province','city','district'], 'safe', 'on'=>'edit_profile'],

        ];
    }

    public function fields()
    {
        return ['id','status','username','nickname','email','phone','credit','point','coin','scores','grade','role','qq','weibo','gender','avatar','signature','address','postcode','district','city','province','country','language','remark','register_ip','created_at'];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return UserToken::getToken($this);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        UserToken::generate($this);
        /*do{
            $authKey = Yii::$app->security->generateRandomString();
        }while(UserToken::findOne(['token'=>$authKey]) === null);
        // TODO 创建User Token
        $this->auth_key = Yii::$app->security->generateRandomString();*/
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = '';
    }

    public function removePhone()
    {
        $this->phone = '';
        $this->save();
    }
    public function getIsAdmin()
    {
        return $this->role == User::ROLE_ADMIN;
    }

    public function getClient()
    {
        // TODO 获取客户端信息
        return static::CLIENT_DESKTOP;
    }

    public function getExpiresAt()
    {
        // TODO 获取过期信息
        return 0;
    }

    public function getRedirect()
    {
        //  TODO 获取子帐号跳转登录连接
        return false;
    }

}
