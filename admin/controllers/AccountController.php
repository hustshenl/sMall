<?php
namespace admin\controllers;

use admin\models\forms\EditProfile;
use admin\models\UpdateAdminForm;
use common\models\access\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use admin\models\forms\LoginForm;
use common\models\access\PasswordResetRequestForm;
use common\models\access\ResetPasswordForm;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


class AccountController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'model' => Yii::$app->user->identity,
        ]);
    }

    public function actionEdit()
    {
        $model = $this->findEditForm(Yii::$app->user->id);
        //var_dump($model);exit;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->update()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Save success!'));
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model,]);
    }

    public function actionLogin()
    {
        $this->layout = 'main-login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            Yii::trace($model->errors);
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionForget()
    {
        $this->layout = 'main-login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('forget', []);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                return $this->render('requestPasswordResetOK');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
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
        $model = User::findOne($id);
        if ($model == NULL) {
            throw new NotFoundHttpException('该用户不存在');
        }
        $item = $model->getOldAttributes();
        return new  EditProfile([], $item);
    }
}
