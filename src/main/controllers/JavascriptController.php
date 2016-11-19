<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/11/11
 * Time: 12:52
 */

namespace main\controllers;

use yii;
use common\components\base\Controller;
use yii\web\Response;
use yii\caching\TagDependency;

/**
 * Main controller
 */
class JavascriptController extends Controller
{
    const CACHE_TAG_SSO_SECRET = 'hustshenl.sinmh.sso.secret';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['httpCache']=[
            'class' => 'yii\filters\HttpCache',
            'lastModified' => function ($action, $params) {
                return strtotime(date('Y-m-d H:00:00'));
            },
            'cacheControlHeader'=>'public, max-age=3600',
        ];
        $behaviors['pageCache']=[
            'class' => 'yii\filters\PageCache',
            //'only' => ['index','search','update','rank','search','search'],
            'duration' => 3600,
            'variations' => [],
            'enabled'=>Yii::$app->request->isGet,
            'dependency'=>[
                'class'=>TagDependency::className(),
                'tags'=>['hust.shenl.small.main.page.javascript'],
            ],
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionConfig()
    {
        $this->layout = false;
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type','application/javascript');
        return $this->render('config');
    }

}
