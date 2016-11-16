<?php
namespace common\behaviors;

use common\components\base\Serializer;
use yii\base\Behavior;
use yii;
use yii\web\Response;

class AjaxReturnBehavior extends Behavior
{

    /**
     * @var $_serializer Serializer;
     */
    protected $_serializer;
    public function init()
    {
        parent::init();
        $this->_serializer = new Serializer();
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function ajax($data)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $callback = Yii::$app->request->get('callback',false);
        if(is_string($data)||is_numeric($data)) $data = [$this->_serializer->collectionEnvelope=>$data];
        $res = $this->_serializer->serialize($data);
        if($callback) {
            Yii::$app->response->format = Response::FORMAT_JSONP;
            $res = [
                'callback'=>$callback,
                'data'=>$res,
            ];
        }
        return $res;
        //return is_array($data) || is_object($data) ? $data : ['status'=>0,'data'=>$data];
    }

    /**
     * @param string|integer $data
     * @param int $status
     * @param string $result
     * @return array|mixed
     */
    public function error($data='error',$status = 1,$result='data')
    {
        //if(is_integer($data))
        $this->_serializer->customer = ['status'=>$status];
        $this->_serializer->collectionEnvelope = $result;
        return $this->ajax($data);
    }

    public function success($data = 'success',$result='data')
    {
        $this->_serializer->customer = ['status'=>0];
        $this->_serializer->collectionEnvelope = $result;
        return $this->ajax($data);
    }
}