<?php
namespace passport\controllers;

use yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\components\base\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\access\LoginForm;
use passport\models\PasswordResetRequestForm;
use passport\models\ResetPasswordForm;
use passport\models\SignupForm;
use common\models\access\User;
use common\helpers\StringHelper;

/**
 * Site controller
 */
class PassportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'except' => ['login','register','error'],
            'rules' => [
                [
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

    /**
     * @param string $redirect
     * @return string|yii\web\Response
     */
    public function actionLogin($redirect='/')
    {
        if(Yii::$app->request->isAjax) return $this->ajaxLogin($redirect);
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return Yii::$app->request->isAjax?$this->success('logged'):$this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(),'') && $model->login()) {
            return Yii::$app->request->isAjax?$this->success('success'):$this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    private function ajaxLogin($redirect='/'){

        if (!Yii::$app->user->isGuest) {
            return $this->redirect($redirect);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(),'') && $model->login()) {
            return $this->redirect($redirect);
        } else {
            // TODO 根据错误信息，输出明确错误提示
            $message = '未知错误';
            foreach ($model->errors as $attribute=>$error){
                $message = reset($error);
            }
            return $this->error(['msg'=>$message]);
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


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param $user User
     * @param $redirect_uri string
     * @return string
     */
    protected function generateCallbackUrl($user,$redirect_uri)
    {
        $auth = $user->getAuthKey();
        // TODO 获取各应用对应的单点登陆密钥
        $ssoSecret = Yii::$app->cache->get(static::CACHE_TAG_SSO_SECRET);
        if(!$ssoSecret) {
            $ssoSecret = Yii::$app->security->generateRandomString();
            Yii::$app->cache->set(static::CACHE_TAG_SSO_SECRET,$ssoSecret);
        }
        $code = Yii::$app->security->encryptByPassword($user->id.'__'.$auth.'__'.time(),$ssoSecret);
        $uri = parse_url($redirect_uri);
        if(!isset($uri['scheme'])) $uri['scheme'] = 'http';
        if(isset($uri['port'])&&$uri['port']!='80') {
            $callbackUrl = $uri['scheme'].'://'.$uri['host'].':'.$uri['port'].'/login/?code='.StringHelper::base64url_encode($code).'&redirect_uri='.urlencode($redirect_uri);
        } else{
            $callbackUrl = $uri['scheme'].'://'.$uri['host'].'/login/?code='.StringHelper::base64url_encode($code).'&redirect_uri='.urlencode($redirect_uri);
        }
        return $callbackUrl;
    }
}
