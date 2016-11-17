<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "{{%application}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property string $name
 * @property string $description
 * @property string $host
 * @property string $ip
 * @property string $secret
 * @property string $token
 * @property string $access_token
 * @property string $expires
 * @property integer $encrypt
 * @property string $aes_key
 * @property string $sso
 * @property string $remark
 * @property integer $created_at
 * @property integer $updated_at
 */
class Application extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'type', 'expires', 'encrypt', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'host', 'ip', 'secret', 'token', 'access_token', 'aes_key'], 'string', 'max' => 255],
            [['sso', 'remark'], 'string', 'max' => 2048],
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
            'type' => Yii::t('common', 'Type'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', '应用描述'),
            'host' => Yii::t('common', 'Host'),
            'ip' => Yii::t('common', 'Ip'),
            'secret' => Yii::t('common', 'Secret'),
            'token' => Yii::t('common', 'Token'),
            'access_token' => Yii::t('common', 'Access Token'),
            'expires' => Yii::t('common', 'Expires'),
            'encrypt' => Yii::t('common', 'Encrypt'),
            'aes_key' => Yii::t('common', 'Aes Key'),
            'sso' => Yii::t('common', 'Sso'),
            'remark' => Yii::t('common', 'Remark'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
