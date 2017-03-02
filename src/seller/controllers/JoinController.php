<?php
namespace seller\controllers;

use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Join controller
 */
class JoinController extends Controller
{
    public $layout = 'main-join';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['apply',],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionApply()
    {
        if(Yii::$app->user->isGuest) return $this->redirect(['index']);
        // TODO 检查用户状态，进入对应步骤
        return $this->redirect(['agreement']);
    }

    public function actionAgreement()
    {
        if(Yii::$app->user->isGuest) return $this->redirect(['index']);
        return $this->render('agreement');
    }
    public function actionCertification($step=1)
    {
        if(Yii::$app->user->isGuest) return $this->redirect(['index']);
        // TODO 依次读取认证表单，若无表单则跳转到结果页
        return '依次读取认证表单，若无表单则跳转到结果页';
    }
    public function actionResult()
    {
        if(Yii::$app->user->isGuest) return $this->redirect(['index']);
        // TODO 结果页
        return '假装这里是结果页';
    }

}
