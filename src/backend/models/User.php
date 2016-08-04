<?php
namespace backend\models;

use yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return false;
        Yii::info($id);
        return new static();
        throw new NotSupportedException('"findIdentity" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('Identity By Access Token is Not Supported.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return 'authKey';
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }



}
