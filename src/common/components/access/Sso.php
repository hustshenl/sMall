<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/11/17
 * Time: 18:29
 */

namespace common\components\access;

use common\models\access\User;
use yii;
use common\helpers\StringHelper;

/**
 * 提供单点登陆相关功能
 * Class Sso
 * @package common\components\access
 */
class Sso
{
    private $_application;
    private $_user;


    /**
     * 生成同步登陆链接
     * @return array
     */
    public function generateSyncLinks()
    {
        // TODO 获取应用配置
        $configs = [
            [
                'host'=>'//www.small.dev.com',
                'route'=>'/sso/login',
                'secret'=>'123456',
            ]
        ];
        $res = [];
        foreach ($configs as $config){
            $res[] = $this->_generateAuthUrl($config);
        }
        return $res;
    }
    /**
     * 服务端Sso登陆
     */
    public function login()
    {

    }

    /**
     * 客户端Sso标记登陆
     */
    public function sign()
    {

    }


    /**
     * 生成授权Url
     * @param $config
     * @return string
     */
    private function _generateAuthUrl($config)
    {
        if(!isset($config['host'])||!isset($config['route'])||!isset($config['secret'])) return false;
        $code = $this->_generateAuthCode($config['secret']);
        $separator = strpos($config['route'],'?')!==false?'&':'?';
        return rtrim($config['host'],'/').'/'.$config['route'].$separator.'code='.$code;
    }

    /**
     * 生成授权代码
     * @param $secret
     * @return string
     */
    private function _generateAuthCode($secret)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $authKey = $user->getAuthKey();
        if (!$secret) {
            $secret = Yii::$app->security->generateRandomString();
        }
        $data = [
            'id'=>$user->id,
            'username'=>$user->username,
            'email'=>$user->email,
            'phone'=>$user->phone,
            'token'=>$authKey,
            'ip'=>Yii::$app->request->getUserIP(),
            'time'=>time(),
        ];
        return StringHelper::base64url_encode(Yii::$app->security->encryptByPassword(http_build_query($data), $secret));
    }

}