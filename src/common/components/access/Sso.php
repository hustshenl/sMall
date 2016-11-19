<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/11/17
 * Time: 18:29
 */

namespace common\components\access;

use common\models\access\User;
use common\models\system\Application;
use yii;
use common\helpers\StringHelper;
use yii\web\Cookie;

/**
 * 提供单点登陆相关功能
 * Class Sso
 * @package common\components\access
 *
 * @property array $error
 */
class Sso extends yii\base\Object
{
    private $_application;
    private $_user;
    private $_error=[];


    /**
     * 获取单点登陆网站配置
     * @return array
     */
    public static function getConfigs()
    {
        $configs = [];
        $apps = Application::findAll(['status'=>Application::STATUS_APPROVED]);
        foreach ($apps as $app){
            if(!isset($app->ssoConfig['status'])||!$app->ssoConfig['status']) continue;
            $configs[] = [
                'host'=>$app->host,
                'sign'=>$app->ssoConfig['sign'],
                'exit'=>$app->ssoConfig['exit'],
                'secret'=>$app->token,
            ];
        }
        return $configs;
    }

    public static function getConfig($identifier=null)
    {
        if($identifier === null) $identifier = Yii::$app->id;
        $app = Application::findOne(['identifier'=>$identifier]);
        if($app === null) return null;
        return [
            'host'=>$app->host,
            'sign'=>$app->ssoConfig['sign'],
            'exit'=>$app->ssoConfig['exit'],
            'secret'=>$app->token,
        ];
    }

    /**
     * 生成同步登陆链接
     * @return array
     */
    public function generateSignLinks()
    {
        $configs = static::getConfigs();
        $res = [];
        foreach ($configs as $config){
            $res[] = $this->_generateAuthUrl($config);
        }
        return $res;
    }
    public function generateExitLinks()
    {
        $configs = static::getConfigs();
        $res = [];
        foreach ($configs as $config){
            $res[] = $this->_generateCleanUrl($config);
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
     * @param $code string
     * @return boolean
     */
    public function sign($code)
    {
        $config = static::getConfig();
        if($config === null) return $this->error('应用配置错误');
        $secret = $config['secret'];
        $params = Yii::$app->security->decryptByPassword(StringHelper::base64url_decode($code),$secret);
        if($params === false) return $this->error('非法登陆信息');
        parse_str($params,$auth);
        if(!isset($auth['time'])||time()-$auth['time']>60*10) return $this->error('登陆超时');
        if(!isset($auth['ip'])||$auth['ip']!=Yii::$app->request->getUserIP()) return $this->error('IP地址发生变化，授权失败。',100001);
        $user = User::findIdentity($auth['id']);
        if(empty($user)||$user->getAuthKey() != $auth['token']) return $this->error('授权失效或者用户不存在！');
        if(Yii::$app->user->login($user,3600 * 24 * 30)){
            Yii::$app->response->cookies->add(
                new Cookie(['name'=>'access_token', 'value'=>Yii::$app->user->identity->getAuthKey(), 'expire'=>time()+3600 * 24 * 30, 'httpOnly'=>false])
            );
            return true;
        }
        return $this->error('登录失败，请检查Cookie设置！');
    }
    public function clean()
    {
        if(Yii::$app->user->logout()){
            Yii::$app->response->cookies->remove(
                new Cookie(['name'=>'access_token', 'value'=>null, 'expire'=>time()-3600, 'httpOnly'=>false])
            );
            return true;
        }
        return $this->error('退出失败，请检查设置！');
    }

    /**
     * 生成授权Url
     * @param $config
     * @return string
     */
    private function _generateAuthUrl($config)
    {
        if(!isset($config['host'])||!isset($config['sign'])||!isset($config['secret'])) return false;
        $code = $this->_generateAuthCode($config['secret']);
        $separator = strpos($config['sign'],'?')!==false?'&':'?';
        return rtrim($config['host'],'/').'/'.$config['sign'].$separator.'code='.$code;
    }
    private function _generateCleanUrl($config)
    {
        if(!isset($config['host'])||!isset($config['exit'])||!isset($config['secret'])) return false;
        $separator = strpos($config['exit'],'?')!==false?'&':'?';
        return rtrim($config['host'],'/').'/'.$config['exit'].$separator.'code=exit';
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

    /**
     * 添加错误信息
     * @param $data string
     * @param int $status
     * @return bool
     */
    public function error($data,$status=1)
    {
        $this->_error = [
            'status'=>$status,
            'data'=>$data,
        ];
        return false;
    }

    public function getError()
    {
        return $this->_error;
    }

}