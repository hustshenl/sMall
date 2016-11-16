<?php
namespace frontend\controllers;

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
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

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

    public function actionLogin($code)
    {
        // TODO 获取密钥，将加密解密等写到组件里面
        $secret = '123456';
        // 解码code，如果含有
        if (!Yii::$app->user->isGuest) {
            return $this->error('Error');
        }
        $params = Yii::$app->security->decryptByPassword(StringHelper::base64url_decode($code),$secret);
        parse_str($params,$auth);
        if(!isset($auth['time'])||time()-$auth['time']>60*10) return $this->error('登陆超时');
        if(!isset($auth['ip'])||$auth['ip']!=Yii::$app->request->getUserIP()) return $this->error('IP地址发生变化，授权失败。',100001);
        var_dump($auth);
        $user = User::findIdentity($auth['id']);
        if(empty($user)||$user->getAuthKey() != $auth[1]) return $this->error('授权失效或者用户不存在！');
        if(Yii::$app->user->login($user,3600 * 24 * 30)){
            Yii::$app->response->cookies->add(
                new Cookie([
                    'name'=>'access_token',
                    'value'=>Yii::$app->user->identity->getAuthKey(),
                    'expire'=>time()+3600 * 24 * 30,
                    'httpOnly'=>false
                ])
            );
            return $this->success('Success');
        }
        return $this->error('登录失败，请检查Cookie设置！');
        return $this->success('Success');
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
