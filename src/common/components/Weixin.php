<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/5 21:02
 * @Description:
 */

namespace common\components;

use yii\base\Component;
use yii\web\NotFoundHttpException;
use yii;
use yii\web\BadRequestHttpException;
use yii\base\InvalidConfigException;
use Exception;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use common\components\Config;

/**
 * Class SinmhSdk
 * @package common\components
 * @property Client $httpClient
 * @property string $token
 * @property string $encodingAesKey
 * @property string $appId
 * @property string $appSecret
 * @property array $errors
 * @property string $firstError
 */
class Weixin extends Component
{

    const EVENT_BEFORE_CREATE = 'beforeCreate';
    const EVENT_AFTER_CREATE = 'afterCreate';
    const EVENT_AFTER_APPROVE = 'afterApprove';
    const EVENT_BEFORE_DELETE = 'beforeDelete';
    const EVENT_AFTER_DELETE = 'afterDelete';

    const CACHE_TAG_COLLECT_RULE = 'sinmh.collect.rules';
    const CACHE_TAG_ACCESS_TOKEN = 'sinmh.sdk.access.token';
    const CACHE_TAG_VERSION = 'sinmh.sdk.version';
    const CACHE_TAG_LICENSE = 'sinmh.sdk.license';
    const CACHE_TAG_BEHAVIOR = 'sinmh.sdk.behavior';

    const AUTH_URL = 'auth/token?';
    const VERSION_URL = 'main/version?';
    const LICENSE_URL = 'auth/license?';
    const BEHAVIOR_URL = 'auth/behavior?';

    private $_errors = [];
    private $_httpClient;
    private $_token;
    private $_encodingAesKey;
    private $_encryptType;
    private $_appId;
    private $_appSecret;
    private $_accessToken;

    public $debug = false;
    public $errCode = 40001;
    public $errMsg = 'access denied!';
    public $cacheDuration = 6048002;

    /**
     * 微信工厂方法
     * @return \EasyWeChat\Foundation\Application
     * @throws InvalidConfigException
     */
    public static function getInstance()
    {
        if (!Yii::$app->has('weixin')) {
            // TODO 创建微信组件
            $wxConfig = Yii::$app->config->get('weixinInfo');

            $config = [
                'debug'=>true,
                'app_id'  => $wxConfig['appId'],         // AppID
                'secret'  => $wxConfig['appSecret'],     // AppSecret
                'token'   => $wxConfig['token'],          // Token
                'aes_key' => $wxConfig['encodingAesKey'],
                /**
                 * 日志配置
                 *
                 * level: 日志级别, 可选为：
                 *         debug/info/notice/warning/error/critical/alert/emergency
                 * file：日志文件位置(绝对路径!!!)，要求可写权限
                 */
                'log' => [
                    'level' => 'debug',
                    //'file'  => '/tmp/easywechat.log',
                ],

                /**
                 * OAuth 配置
                 *
                 * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
                 * callback：OAuth授权完成后的回调页地址
                 */
                'oauth' => [
                    'scopes'   => ['snsapi_base'],
                    'callback' => '/examples/oauth_callback.php',
                ],
            ];
            Yii::$app->set('weixin',
                Yii::createObject([
                    'class' => 'EasyWeChat\Foundation\Application',
                ], [$config]
                )
            );
        }
        return Yii::$app->get('weixin');
    }

}