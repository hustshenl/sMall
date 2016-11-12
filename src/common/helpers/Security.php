<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/11/12
 * Time: 22:38
 */

namespace common\helpers;

use common\components\base\Config;
use yii;

class Security
{
    /**
     * @param $string
     * @return null|string
     */
    public static function rsaDecrypt($string)
    {
        /** @var Config $config */
        $config = Yii::$app->config;
        $rsaStatus = $config->get('rsa', 'status');
        if (!$rsaStatus) return $string;
        $privateKey = openssl_pkey_get_private($config->get('rsa', 'privateKey'));
        if (openssl_private_decrypt(base64_decode($string), $decrypted, $privateKey))
            return $decrypted;
        return null;


    }
}