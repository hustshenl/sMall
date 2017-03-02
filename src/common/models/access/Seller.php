<?php
namespace common\models\access;

use common\behaviors\IPBehavior;
use yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Seller model
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property string $username
 * @property integer $user_id
 * @property integer $store_id
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
 * @property string $password write-only password
 */
class Seller extends ActiveRecord implements IdentityInterface
{
    const STATUS_FORBIDDEN = 0;
    const STATUS_ACTIVE = 1;

    const TYPE_MASTER = 0x1;
    const TYPE_SLAVE = 0x1;


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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
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
            [['status', 'user_id', 'store_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['username', 'name', 'avatar', 'signature', 'department', 'position'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 64],
            [['permission', 'remark'], 'string', 'max' => 2048],
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


    public function removePhone()
    {
        $this->phone = '';
        $this->save();
    }
}
