<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/4/7 10:02
 * @Description:
 */

namespace api\components;

use yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


/**
 * Class RestController
 * @package api\components
 *
 * @property string $jsonCallback
 * @property array $param 请求参数数组
 */
class RestController extends Controller {
    protected $_callback = false;
    public $serializer = [
        'class' => 'common\components\base\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @var string the parameter name for passing the access token
     */
    public $tokenParam = 'access-token';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if($this->jsonCallback) {
            $behaviors['contentNegotiator']['formats']['*/*'] = Response::FORMAT_JSONP ;
            $behaviors['contentNegotiator']['formats']['application/xml'] = Response::FORMAT_JSONP ;
            $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSONP ;
        }else{
            $behaviors['contentNegotiator']['formats']['*/*'] = Response::FORMAT_JSON ;
            $behaviors['contentNegotiator']['formats']['application/xml'] = Response::FORMAT_JSON ;
            $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON ;
        }

        $behaviors['corsFilter'] = [
            'class' => yii\filters\Cors::className(),
            'cors' => Yii::$app->params['cors'],
        ];
        return $behaviors;
    }

    public function response($data,$envelope = false,$status=0)
    {
        $this->serializer['customer'] = ['status'=>$status];
        if($envelope===false&&(is_string($data)||is_numeric($data))) {
                $this->serializer['collectionEnvelope'] = 'data';
                return [$this->serializer['collectionEnvelope'] =>$data];
        }else if(is_string($envelope)) {
            $this->serializer['collectionEnvelope'] = $envelope;
        }
        return $data;
    }
    public function error($data,$status=1)
    {
        return $this->response($data,false,$status);
    }
    public function success($data)
    {
        return $this->response($data);
    }
    public function getParam()
    {
        $post = Yii::$app->request->post();
        if(empty($post)) $post = json_decode(Yii::$app->request->rawBody,true);
        return ArrayHelper::merge(Yii::$app->request->get(),$post);
    }

    protected function getJsonCallback()
    {
        if($this->_callback) return $this->_callback;
        return $this->_callback = Yii::$app->request->get("callback",Yii::$app->request->get("jsoncallback",false));
    }

    public function setEnvelope($envelope)
    {
        $this->serializer['collectionEnvelope'] = $envelope;
    }
    protected function serializeData($data)
    {
        if($this->jsonCallback)
        {
            $result['data'] = parent::serializeData($data);
            $result['callback'] = $this->jsonCallback;
            return $result;
        }
        return parent::serializeData($data);
    }
    public function actionOptions()
    {
        return [];
    }

    public function login()
    {
        $accessToken = Yii::$app->request->get($this->tokenParam);
        $identity = Yii::$app->user->loginByAccessToken($accessToken);
        if ($identity !== null) {
            return true;
        }
        return false;
    }

    /**
     * @param $msg string|array
     */
    public function disconnect($msg)
    {
        ob_start();
        echo is_array($msg)?Json::encode($msg):$msg;
        $size=ob_get_length();
        header("Content-Length: $size"); //告诉浏览器数据长度,浏览器接收到此长度数据后就不再接收数据
        header("Connection: Close"); //告诉浏览器关闭当前连接,即为短连接
        Yii::$app->response->send();
        echo str_pad('',128*1024);
        ob_flush();
        flush();
        ignore_user_abort(true);
    }
}