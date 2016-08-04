<?php
namespace member\controllers;

use common\components\Image;
use common\helpers\StringHelper;
use common\models\access\Auth;
use member\models\forms\EditAvatar;
use member\models\forms\EditPassword;
use member\models\forms\EditProfile;
use common\models\access\User;
use member\models\forms\SignupForm;
use yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use member\models\forms\LoginForm;
use common\models\access\PasswordResetRequestForm;
use common\models\access\ResetPasswordForm;
use yii\filters\VerbFilter;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use xj\oauth\QqAuth;
use xj\oauth\WeiboAuth;
use xj\oauth\WeixinAuth;


class AccountController extends Controller
{

    const CACHE_TAG_SSO_SECRET = 'hustshenl.sinmh.sso.secret';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'bind', 'auth', 'error', 'register', 'register', 'request-password-reset','reset-password'],
                        'allow' => true,
                    ],
                    [
                        //'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    /**
     * Success Callback
     * @param QqAuth|WeiboAuth $client
     * @see http://wiki.connect.qq.com/get_user_info
     * @see http://stuff.cebe.cc/yii2docs/yii-authclient-authaction.html
     * @return bool
     */
    public function successCallback($client) {
        $id = $client->getId(); // qq | sina | weixin
        $attributes = $client->getUserAttributes(); // basic info
        $openid = Auth::getOpenidFromClient($attributes,$id);
        //var_dump(Auth::getOpenidFromClient($attributes,$id), $attributes);exit;
        /**
         * @var Auth $auth
         */
        $auth = Auth::getAuth($openid,$client->clientId,$id);
        $redirect_uri = Yii::$app->request->get('redirect_uri');
        if($auth->user_id <= 0){
            // TODO 绑定信息， 将来源信息写入数据库，auth_id写入session，详细信息写入cookie，跳转到绑定页面
            Yii::$app->session->set('auth_id', $auth->id);
            Yii::trace($client->getUserInfo());
            //Yii::$app->response->cookies->add(new Cookie(['name'=>'user_info','value'=>$client->getUserInfo()]));
            return $this->redirect(['bind','redirect_uri'=>$redirect_uri]);
        }else{
            // TODO 登陆成功，跳转到首页
            $user = User::findIdentity($auth->user_id);
            Yii::$app->user->login($user, 3600 * 24 * 30);
            if($redirect_uri) return $this->redirect($this->generateCallbackUrl(Yii::$app->user->identity,$redirect_uri));
            return $this->redirect(['index']);
        }
        //Yii::$app->session->set('auth',['']);
        //$openid = $client->getOpenid(); //user openid
        //$userInfo = $client->getUserInfo(); // user extend info
        //var_dump($id, $attributes);exit;
        var_dump($client->clientId, $attributes);exit;

    }
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => Yii::$app->user->identity,
        ]);
    }

    public function actionEdit(){
        $model = $this->findEditForm(Yii::$app->user->id);
        //var_dump($model);exit;
        if ($model->load(Yii::$app->getRequest()->post())&&$model->update()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Save success!'));
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model,]);
    }

    public function actionPassword(){
        $model = $this->findPasswordForm(Yii::$app->user->id);
        //var_dump($model);exit;
        if ($model->load(Yii::$app->getRequest()->post())&&$model->update()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Save success!'));
            return $this->redirect(['index']);
        }

        return $this->render('password', ['model' => $model,]);
    }

    public function actionAvatar(){
        $model = $this->findAvatarForm(Yii::$app->user->id);
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->getRequest()->post());
            $image = new Image(['model'=>$model,'field'=>'avatar','category'=>'avatar']);
            $image->create();
            $model->avatar = $image->image->url;
            Yii::trace($image->image);
            Yii::trace($model->avatar);
            if ($model->update()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Save success!'));
                return $this->redirect(['index']);
            }else{
                Yii::$app->getSession()->setFlash('error', Yii::t('common', 'Save failed!'));
            }
        }
        /*if ($model->load(Yii::$app->getRequest()->post())&&$model->update()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Save success!'));
            return $this->redirect(['index']);
        }*/

        return $this->render('avatar', ['model' => $model,]);
    }

    public function actionHome()
    {
        return $this->redirect($this->generateCallbackUrl(Yii::$app->user->identity,Yii::$app->params['domain']['frontend']));
    }
    public function actionLogin($redirect_uri='')
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            if($redirect_uri) return $this->redirect($this->generateCallbackUrl(Yii::$app->user->identity,$redirect_uri));
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if($redirect_uri) return $this->redirect($this->generateCallbackUrl(Yii::$app->user->identity,$redirect_uri));
            return $this->goBack();
        } else {
            Yii::trace($model->errors);
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionBind($redirect_uri='')
    {
        if(Yii::$app->session->get('auth_id',false) == false) $this->redirect('login');
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            if($redirect_uri) return $this->redirect($this->generateCallbackUrl(Yii::$app->user->identity,$redirect_uri));
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if($redirect_uri) return $this->redirect($this->generateCallbackUrl(Yii::$app->user->identity,$redirect_uri));
            return $this->goHome();
        } else {
            Yii::trace($model->errors);
            return $this->render('bind', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['account/login']);
    }

    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                return $this->render('requestPasswordResetOK');
                //return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordReset', [
            'model' => $model,
        ]);
    }

    public function actionRegister($redirect_uri='')
    {
        $this->layout = 'login';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->getSession()->setFlash('success', 'Register Success.');
                Yii::$app->user->login(User::findIdentity($user->id), 3600 * 24 * 30);
                if($redirect_uri) return $this->redirect($this->generateCallbackUrl(Yii::$app->user->identity,$redirect_uri));
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, Register Failed.');
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        $this->layout = 'login';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    protected function findEditForm($id)
    {
        /**
         * @var $model User
         */
        $model = User::findOne($id);
        if($model == NULL){
            throw new NotFoundHttpException('该用户不存在');
        }
        $item = $model->oldAttributes;
        return new  EditProfile([],$item);
    }

    protected function findPasswordForm($id)
    {
        /**
         * @var $model User
         */
        $model = User::findOne($id);
        if($model == NULL){
            throw new NotFoundHttpException('该用户不存在');
        }
        $item = $model->oldAttributes;
        return new  EditPassword([],$item);
    }

    protected function findAvatarForm($id)
    {
        /**
         * @var $model User
         */
        $model = User::findOne($id);
        if($model == NULL){
            throw new NotFoundHttpException('该用户不存在');
        }
        $item = $model->oldAttributes;
        return new  EditAvatar([],$item);
    }

    /**
     * @param $user User
     * @param $redirect_uri string
     * @return string
     */
    protected function generateCallbackUrl($user,$redirect_uri)
    {
        $auth = $user->getAuthKey();
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
