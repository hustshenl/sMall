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
use passport\models\RegisterForm;
use common\models\access\User;
use common\helpers\StringHelper;
use yii\web\Response;


class ValidatorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'except' => ['username', 'email', 'phone', 'index','code', 'error', 'exit-links'],
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

    public function actionUsername()
    {
        //sleep(2);
        $username = trim(Yii::$app->request->post('username'));
        $len = StringHelper::length($username);
        if($len>20||$len<4) return $this->error('用户名长度必须大于4并且小于20字符（一个汉字占2字符）');
        $res = preg_match('/^[A-Za-z0-9_\-\p{Han}]+$/u',$username);
        if(!$res) return $this->error('仅支持汉字、字母、数字、“-”“_”的组合');
        $user = User::findOne(['username'=>$username]);
        if(!empty($user)) return $this->error('该用户名已被使用，请重新输入');
        return $this->success('SUCCESS');
    }
    public function actionPhone()
    {
        //sleep(2);
        $phone = trim(Yii::$app->request->post('phone'));
        if(!preg_match('/^1[345678]\d{9}$/i',$phone)) return $this->error('仅支持中国大陆手机号码');
        $user = User::findOne(['phone'=>$phone]);
        if(!empty($user)) return $this->error('手机号已注册，继续注册将与原账号解绑',2);
        return $this->success('SUCCESS');
    }

    /**
     * 验证密码强度
     * $res = preg_replace('/^(?:([a-z])|([A-Z])|([0-9])|(.)){6,}|(.)+$/','$1$2$3$4$5','aA.2');
     */
    public function actionCode()
    {
        $validator = new yii\captcha\CaptchaValidator();
        if(!$validator->validate(Yii::$app->request->post('captcha'),$res))
            return $this->error('图形验证码不正确',1);
        $phone=Yii::$app->request->post('phone');
        if(!preg_match('/^1[345678]\d{9}$/i',$phone)) return $this->error('手机号码不正确，仅支持中国大陆手机号码',2);
        $code = '1234';
        // TODO 发送手机验证码(发送次数在发送处控制)
        $verification = ['phone'=>$phone,'code'=>$code,'send_at'=>time()];
        Yii::$app->session->set('verification.phone',$verification);
        return $this->success('验证码已经成发送成功');
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
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->register()) {
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
