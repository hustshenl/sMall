<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/5 21:02
 * @Description:
 */

namespace common\components\base;

use yii\base\Component;
use yii\web\UploadedFile;
use yii\web\BadRequestHttpException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii;
use yii\helpers\ArrayHelper;
use common\models\base\Attachment as AttachmentModel;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;


/**
 * 处理文件下载任务
 * @package common\components\base
 * @property Client $httpClient
 * @property string $url
 * @property string $fileExt
 * @property string $fileName
 * @property yii\httpclient\Response $response
 * @property array $errors
 * @property string $firstError
 * @property UploadedFile $instance
 */
class HttpRequest extends Component {

    const CURL_TIMEOUT = 10;
    const CURL_CONNECT_TIMEOUT = 5;

    public $maxSize=false;

    public $referer = '';

    public $curlTimeout = self::CURL_TIMEOUT;
    public $curlConnectTimeout = self::CURL_CONNECT_TIMEOUT;

    /** @var yii\httpclient\Response */
    private $_response = null;

    private $_userAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36';

    private $_url;
    private $_ext;
    private $_errors=[];
    private $_httpClient;

    public function init()
    {
        parent::init();
    }

    /**
     * @param $url
     * @param string $referer
     * @return bool|yii\httpclient\Response
     * @throws InvalidConfigException
     */
    public function send($url=null, $referer = null)
    {
        if ($url === null) $url = $this->url;
        if ($referer === null) $referer = $this->referer;
        $retry = 0;
        $url = $this->_parseUrl($url);
        $uri = parse_url($url);
        $requestOption = [
            CURLOPT_CONNECTTIMEOUT => $this->curlConnectTimeout, // connection timeout
            CURLOPT_TIMEOUT => $this->curlTimeout, // data receiving timeout
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_ENCODING => 'gzip,deflate',
            //CURLOPT_COOKIE=>'',
            //CURLOPT_REFERER=>'',
        ];
        $proxies = ArrayHelper::getValue(Yii::$app->params['collect'], 'proxy', []);
        $proxy = ArrayHelper::getValue($proxies, $uri['host'], false);
        if ($proxy !== false) {
            if (is_string($proxy)) $requestOption[CURLOPT_PROXY] = $proxy;
            elseif (is_array($proxy)) {
                $types = [
                    'http' => CURLPROXY_HTTP,
                    'socks4' => CURLPROXY_SOCKS4,
                    'socks5' => CURLPROXY_SOCKS5,
                ];
                $requestOption[CURLOPT_PROXYTYPE] = isset($proxy['type']) && in_array($proxy['type'], $types) ? $types[$proxy['type']] : CURLPROXY_HTTP;
                if (isset($proxy['host'])) $requestOption[CURLOPT_PROXY] = $proxy['host'];
                else throw new InvalidConfigException('代理服务器没有正确配置，请正确配置采集代理服务器！');
                if (isset($proxy['username'],$proxy['password'])) $requestOption[CURLOPT_PROXYUSERPWD] = $proxy['username'].':'.$proxy['password'];
            }
        }
        $cookies = ArrayHelper::getValue(Yii::$app->params['collect'], 'cookie', []);
        $cookie = ArrayHelper::getValue($cookies, $uri['host'], false);
        if($cookie!==false) $requestOption[CURLOPT_COOKIE] = $cookie;

        $requestHeader = [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'User-Agent' => $this->userAgent,
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
        ];
        if (isset($uri['host'])) $requestHeader['Host'] = $uri['host'];
        if (!empty($referer)) $requestHeader['Referer'] = $referer;
        do {
            try {
                $response = $this->httpClient->get($url, null, $requestHeader, $requestOption)->send();
                if ($response->isOk) {
                    return $this->response = $response;
                } else {
                    $this->addError('获取内容失败，statusCode:' . $response->statusCode);
                    return false;
                }
            } catch (\Exception $e) {
                $retry++;
            };
        } while ($retry < 4);
        $this->addError('网络连接超时！重试次数:' . $retry);
        return false;
    }

    private function _parseUrl($url){
        $str = '/[^0-9a-zA-Z\/:\?\&=%\\\\\.]+/u';//匹配各种需要转码的字符
        if(preg_match_all($str,$url,$matchArray)){//匹配中文，返回数组
            foreach($matchArray[0] as $key=>$val){
                $url=str_replace($val, rawurlencode($val), $url);//将转译替换中文
            }
        }
        if (preg_match('/^\\/\\//i', $url)) {$url = 'http:'.$url;}
        if (!preg_match('/^https?:\\/\\//i', $url)) {$url = 'http://'.$url;}
        return $url;
    }


    public function getExt()
    {
        return $this->_ext ? $this->_ext : $this->_ext = strtolower(pathinfo($this->url, PATHINFO_EXTENSION));
    }
    public function setExt($ext)
    {
        $this->_ext = $ext;
    }

    /**
     * 获取Http请求实例
     * @return object
     * @throws yii\base\InvalidConfigException
     */
    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            if (!function_exists('curl_init')) throw new InvalidConfigException('没有启用Curl,请配置PHP cUrl组件！');
            $this->_httpClient = Yii::createObject([
                'class' => Client::className(),
                'transport' => CurlTransport::className(),
            ]);
        }
        return $this->_httpClient;
    }

    public function getUserAgent()
    {
        return $this->_userAgent;
    }

    public function setUserAgent($userAgent)
    {
        $this->_userAgent = $userAgent;
    }

    public function getUrl()
    {
        if ($this->_url === null ) throw new  InvalidConfigException('发送Http请求必须设置URL！');
        return $this->_url;
    }

    public function setUrl($url)
    {
        $this->_url = $url;
    }
    public function getResponse()
    {
        if($this->_response === null) {
            $this->send();
        }
        return $this->_response;
    }

    public function setResponse($response)
    {
        $this->_response = $response;
    }
    public function getErrors()
    {
        return $this->_errors;
    }
    public function getFirstError()
    {
        $errors = $this->errors;
        return count($errors)>0 ? reset($errors) : '';
    }
    public function addError($error)
    {
        $this->_errors[] = $error;
        return false;
    }
    public function clearError()
    {
        $this->_errors = [];
    }

}