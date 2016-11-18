<?php
namespace main\controllers;

use common\components\access\Sso;
use common\helpers\StringHelper;
use common\models\access\User;
use yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
//use yii\web\Controller;
use common\components\base\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\access\LoginForm;
use main\models\PasswordResetRequestForm;
use main\models\ResetPasswordForm;
use main\models\SignupForm;
use main\models\ContactForm;

/**
 * Site controller
 */
class SsoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['logout', 'signup'],
            'rules' => [
                [
                    'actions' => ['signup'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['logout'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSign($code)
    {
        $sso = new Sso();
        if($sso->sign($code)){
            return $this->success('Success');
        }
        $error = $sso->error;
        return $this->error(isset($error['data'])?$error['data']:'Error',isset($error['status'])?$error['status']:1);
    }

    public function actionExit()
    {

        $sso = new Sso();
        if($sso->clean()){
            return $this->success('Success');
        }
        $error = $sso->error;
        return $this->error(isset($error['data'])?$error['data']:'Error',isset($error['status'])?$error['status']:1);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
