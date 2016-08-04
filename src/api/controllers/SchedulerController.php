<?php
namespace api\controllers;

use common\components\Scheduler;
use yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use common\models\comic\Comic;
use api\components\RestController;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Scheduler controller
 */
class SchedulerController extends RestController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'only' => ['index'],
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ];
        return $behaviors;
    }


    public function actionIndex()
    {
        return $this->success('index');
    }

    public function actionLaunch()
    {
        // 断开浏览器链接
        $this->disconnect(['status'=>0,'data'=>'OK']);
        // 下载任务，重置月/周/日的 点击/人气
        $service = new Scheduler();
        $service->launch();
        exit;
    }

}
