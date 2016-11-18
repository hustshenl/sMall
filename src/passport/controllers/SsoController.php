<?php
namespace passport\controllers;

use common\components\access\Sso;
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
use yii\web\Response;


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
            'except' => ['user', 'login', 'register', 'index','salt', 'error', 'exit-links'],
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
        $behaviors['corsFilter'] = [
            'class' => yii\filters\Cors::className(),
            'cors' => [
                // TODO 完善具体允许的域名
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'OPTIONS', 'DELETE', 'PUT'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
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
        $this->layout = false;
        return $this->render('index');
    }

    public function actionUser()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->success(['data' => Yii::$app->user->identity]);
        }
        return $this->error('Error.');
    }

    public function actionSalt()
    {
        $salt = time();
        Yii::$app->session->set('sso.salt',$salt);
        return $this->success($salt);
    }

    public function actionLogin($redirect = '/')
    {
        if (!Yii::$app->user->isGuest) {
            return $this->success('Success');
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->get(), '') && $model->login()) {
            return $this->success(['data' => Yii::$app->user->identity]);
        } else {
            // TODO 根据错误信息，输出明确错误提示
            $message = '未知错误';
            foreach ($model->errors as $attribute => $error) {
                $message = reset($error);
            }
            return $this->error(['msg' => $message]);
        }
    }

    public function actionSignLinks()
    {
        if (Yii::$app->user->isGuest) {
            return $this->error('用户未登陆');
        }
        return $this->success(['data'=>(new Sso())->generateSignLinks()]);
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

    public function actionExitLinks()
    {
        if (Yii::$app->user->isGuest) {
            return $this->error('用户未登陆');
        }
        Yii::$app->user->logout();
        //Yii::$app->response->cookies->remove();
        return $this->success(['data'=>(new Sso())->generateExitLinks()]);
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

}
