<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/10/19
 * Time: 18:39
 */

namespace common\components\base;


use common\behaviors\AjaxReturnBehavior;
use yii\helpers\Url;
use yii;

/**
 * Class Controller
 * @package admin\components
 * @method array|mixed success($data = 'success',$result='data')
 * @method array|mixed error($data='error',$status = 1,$result='data')
 * @method array|mixed ajax($data)
 *
 */
class Controller extends yii\web\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = AjaxReturnBehavior::className();
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if(Yii::$app->request->isAjax){
            $this->layout = false;
        }
        return parent::beforeAction($action);
    }

    public function redirect($url, $statusCode = 302)
    {
        if(Yii::$app->request->isAjax){
            if(is_array($url)){
                $url = Url::to($url);
            }
            return $this->success(['redirect'=>$url,'data'=>'Success.']);
        }
        return parent::redirect($url, $statusCode);
    }
}