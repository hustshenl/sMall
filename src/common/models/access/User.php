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
 * @property string $identity
 * @property string $identity_sn
 * @property string $auth_key
 * @property string $access_token
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
 * @property integer $author_id
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
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_FORBIDDEN = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_USER = 0x1;
    const ROLE_SELLER = 0x10;
    const ROLE_ADMIN = 0x1000;
    const ROLE_SYSTEM = 0x10000;

    const AUTHOR_UNAUTH = 0;
    const AUTHOR_ACTIVE = 1;
    const AUTHOR_FORBIDDEN = 2;

    private $_isAuthor = -1;

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
            IPBehavior::className(),
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
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'status' => Yii::t('common', 'Approve status'),
            'username' => Yii::t('common', 'Username'),
            'nickname' => Yii::t('common', 'Nickname'),
            'auth_key' => Yii::t('common', 'Auth Key'),
            'password_hash' => Yii::t('common', 'Password Hash'),
            'password_reset_token' => Yii::t('common', 'Password Reset Token'),
            'access_token' => Yii::t('common', 'Access Token'),
            'identity' => Yii::t('common', 'Identity'),
            'identity_sn' => Yii::t('common', 'Identity Sn'),
            'qq' => Yii::t('common', 'QQ'),
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
            'author_id' => Yii::t('common', 'Author ID'),
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
            'create_by' => Yii::t('common', 'Create By'),
            'update_by' => Yii::t('common', 'Update By'),
        ];
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
        return $this->auth_key;
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
        $this->login_ip = ip2long(Yii::$app->request->getUserIP());
        $this->login_at = time();
        $this->auth_key = Yii::$app->security->generateRandomString();
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
        $this->password_reset_token = null;
    }

    public function getIsAdmin()
    {
        return $this->role == User::ROLE_ADMIN;
    }

    public function getIsAuthor()
    {
        if ($this->_isAuthor == -1) $this->_isAuthor = $this->author !== null;
        return $this->_isAuthor;
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(),['id'=>'author_id']);
    }

    public function getAuthorStatus()
    {
        if($this->author_id<=0||$this->author == null||$this->author->status == Author::STATUS_CREATED) return static::AUTHOR_UNAUTH;
        if($this->author->status == Author::STATUS_APPROVED) return static::AUTHOR_ACTIVE;
        return static::AUTHOR_FORBIDDEN;
    }

    public function getAvatarUrl()
    {
        if (empty($this->avatar)) return \Yii::$app->params['domain']['resource'] . 'images/default/avatar.png';
        if (!preg_match('/\b(([\w-]+:\/\/?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/)))/i', $this->avatar)) {
            return \Yii::$app->params['domain']['resource'] . $this->avatar;
        }
        return $this->avatar;
    }

    public function getCanAuthAuthor()
    {
        if(empty($this->identity)||empty($this->identity_sn)||empty($this->phone)||empty($this->qq)||empty($this->address))
            return false;
        return true;
    }

}
