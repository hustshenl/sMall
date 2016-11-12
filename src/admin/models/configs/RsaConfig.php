<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/19 13:09
 * @Description:
 */

namespace admin\models\configs;

use Yii;
use yii\base\Model;

/**
 * BaseForm
 */
class RsaConfig extends Model
{
    public $status;
    public $privateKey;
    public $publicKey;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'boolean'],
            [['privateKey', 'publicKey'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'status' => Yii::t('admin', 'Rsa开启状态'),
            'privateKey' => Yii::t('admin', '私钥'),
            'publicKey' => Yii::t('admin', '公钥'),
        ];
    }

    public function load($data, $formName = null)
    {
        if(!parent::load($data, $formName)) return false;
        if(!$this->status) return true;
        $privateKey = openssl_pkey_get_private($this->privateKey);
        $publicKey = openssl_pkey_get_public($this->publicKey);
        if ($privateKey === false || $publicKey === false) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', '不合法的密钥格式。'));
            return false;
        } else {
            $source = Yii::$app->security->generateRandomString();
            openssl_private_encrypt($source, $encrypted, $privateKey);
            openssl_public_decrypt($encrypted, $decrypted, $publicKey);
            if ($decrypted != $source) {
                Yii::$app->getSession()->setFlash('error', Yii::t('common', '密钥不配对。'));
                return false;
            }
        }
        return true;
    }

}
