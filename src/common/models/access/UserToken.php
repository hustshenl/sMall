<?php

namespace common\models\access;

use common\behaviors\TimeBehavior;
use yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user_token}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $token
 * @property integer $client
 * @property string $expires_at
 * @property string $created_at
 */
class UserToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
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
            [['user_id', 'token'], 'required'],
            [['user_id', 'client', 'expires_at', 'created_at'], 'integer'],
            [['token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'token' => Yii::t('common', 'Token'),
            'client' => Yii::t('common', '客户端类型0pc/1wap'),
            'expires_at' => Yii::t('common', 'Expires At'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    /**
     * @param $user User
     * @return string
     */
    public static function generate($user)
    {
        do{
            $token = Yii::$app->security->generateRandomString();
        }while(static::findOne(['token'=>$token]) !== null);
        $userToken = static::findOne(['user_id'=>$user->id,'client'=>$user->getClient()]);
        if($userToken === null){
            $userToken = new static();
            $userToken->user_id = $user->id;
            $userToken->client = $user->getClient();
        }
        $userToken->token = $token;
        $userToken->expires_at = $user->getExpiresAt();
        $userToken->save();
        return $userToken;
    }

    /**
     * @param $user User
     * @return string
     */
    public static function getToken($user)
    {
        $userToken = static::findOne(['user_id'=>$user->id,'client'=>$user->getClient()]);
        return $userToken===null||($userToken->expires_at>0&&$userToken->expires_at<time())?null:$userToken->token;
    }
}
