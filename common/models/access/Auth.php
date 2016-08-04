<?php

namespace common\models\access;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%auth}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $source
 * @property string $openid
 * @property integer $status
 * @property string $appid
 * @property integer $created_at
 * @property integer $updated_at
 */
class Auth extends \yii\db\ActiveRecord
{

    const STATUS_SUBSCRIBED = 1;
    const STATUS_UN_SUBSCRIBE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth}}';
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
            [['source', 'openid', 'appid'], 'required'],
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['user_id', 'status'], 'default', 'value'=>0],
            [['source', 'openid', 'appid'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', '用户ID'),
            'source' => Yii::t('common', '来源ID'),
            'openid' => Yii::t('common', 'OpenID'),
            'status' => Yii::t('common', '状态'),
            'appid' => Yii::t('common', 'Appid'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    public static function getAuth($openid,$appid,$source){
        $auth = Auth::findOne(['openid'=>$openid,'appid'=>$appid,'source'=>$source]);
        if($auth == null){
            return static::add($openid,$appid,$source);
        }
        return $auth;
    }
    public static function add($openid,$appid,$source)
    {
        $auth = new Auth();
        $auth->openid = $openid;
        $auth->appid = $appid;
        $auth->source = $source;
        $auth->status = static::STATUS_SUBSCRIBED;
        if($auth->save()){
            return$auth;
        }
        Yii::trace($auth->errors);
        throw new \PDOException($auth->errors);
    }
    public static function getOpenidFromClient($attributes,$id)
    {
        if($id == 'qq'){
            return ArrayHelper::getValue($attributes,'openid');
        }
    }
}
