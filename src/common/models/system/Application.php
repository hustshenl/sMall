<?php

namespace common\models\system;

use common\behaviors\SlugBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%application}}".
 *
 * @property array $ssoConfig
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property string $name
 * @property string $identifier
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
 *
 */
class Application extends \yii\db\ActiveRecord
{
    const TYPE_PRESET = 0;
    const TYPE_EXTERNAL = 1;

    const STATUS_CREATED = 0;
    const STATUS_APPROVED = 1;

    public static $types = [
        self::TYPE_PRESET => '内置应用',
        self::TYPE_EXTERNAL => '外部应用',
    ];

    private $_ssoConfig = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application}}';
    }

    public function behaviors()
    {
        $behaviors =  parent::behaviors();
        //$behaviors[] = SlugBehavior::className();
        $behaviors[] = TimestampBehavior::className();
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','identifier', 'host'], 'required'],
            [['identifier'],'unique'],
            [['status', 'type', 'expires', 'encrypt', 'created_at', 'updated_at'], 'integer'],
            [['name', 'identifier', 'description', 'host', 'ip', 'secret', 'token', 'access_token', 'aes_key'], 'string', 'max' => 255],
            [['remark'], 'string', 'max' => 2048],
            [['ssoConfig'], 'safe'],
            [['type'], 'default','value'=>self::TYPE_PRESET],
        ];
    }

    public function load($data, $formName = null)
    {
        if (!parent::load($data, $formName)) return false;
        if (empty($this->secret)) $this->secret = Yii::$app->security->generateRandomString();
        if (empty($this->token)) $this->token = Yii::$app->security->generateRandomString();
        if (empty($this->aes_key) && $this->encrypt == 1) {
            $bytes = Yii::$app->security->generateRandomKey(43);
            $this->aes_key = strtr(substr(base64_encode($bytes), 0, 43), '+/', '01');
        }
        $this->formatSsoConfig();
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'status' => Yii::t('common', '状态'),
            'type' => Yii::t('common', '类型'),
            'name' => Yii::t('common', '名称'),
            'identifier' => Yii::t('common', '唯一标识'),
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


    public function formatSsoConfig()
    {
        $config = $this->_ssoConfig;
        if ($this->type == self::TYPE_PRESET) {
            $config = in_array($this->identifier, ['passport']) ? ['status' => 0] : ['status' => 1];
        }
        if(!isset($config['sign'])||empty($config['sign'])) $config['sign'] = '/sso/sign';
        if(!isset($config['exit'])||empty($config['exit'])) $config['exit'] = '/sso/exit';
        $this->sso = json_encode($config);
    }

    public function setSsoConfig($config)
    {
        $this->_ssoConfig = $config;
    }

    /**
     * 输出格式化的单点登陆配置
     * @return string
     */
    public function getSsoConfig()
    {
        $config = is_array($this->sso)?$this->sso:json_decode($this->sso,true);
        if ($this->type == self::TYPE_PRESET) {
            $config = in_array($this->identifier, ['app-passport','app-resource']) ? ['status' => 0] : ['status' => 1];
        }
        if(!isset($config['sign'])||empty($config['sign'])) $config['sign'] = '/sso/sign';
        if(!isset($config['exit'])||empty($config['exit'])) $config['exit'] = '/sso/exit';
        return is_array($config)?$config:json_decode($config,true);
    }


}
