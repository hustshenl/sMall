<?php

namespace admin\controllers\access;

use admin\models\access\Admin;
use common\behaviors\AjaxReturnBehavior;
use EasyWeChat\Server\BadRequestException;
use yii\web\BadRequestHttpException;
use Yii;
use mdm\admin\models\Assignment;
use admin\models\access\AdminSearch;
use admin\models\access\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use admin\models\forms\Admin as AdminForm;

/**
 * AssignmentController implements the CRUD actions for Assignment model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AssignmentController extends Controller
{
    public $userClassName;
    public $idField = 'id';
    public $usernameField = 'username';
    public $fullnameField;
    public $searchClass;
    public $extraColumns = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ?: 'mdm\admin\models\User';
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'assign' => ['post'],
                    'assign' => ['post'],
                    'revoke' => ['post'],
                ],
            ],
            [
                'class' => AjaxReturnBehavior::className()
            ]
        ];
    }

    /**
     * Lists all Assignment models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new AdminSearch;
        $formName = Yii::$app->request->isAjax ? '' : $searchModel->formName();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams(),$formName);

        return Yii::$app->request->isAjax ? $this->success($dataProvider, 'results') : $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'idField' => $this->idField,
            'usernameField' => $this->usernameField,
            'extraColumns' => $this->extraColumns,
        ]);
    }
    public function actionUsers()
    {

        $searchModel = new UserSearch;
        $formName = Yii::$app->request->isAjax ? '' : $searchModel->formName();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams(),$formName);

        return Yii::$app->request->isAjax ? $this->success($dataProvider, 'results') : $this->render('users', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'idField' => $this->idField,
            'usernameField' => $this->usernameField,
            'extraColumns' => $this->extraColumns,
        ]);
    }

    public function actionCreate()
    {
        $model = new AdminForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if ($user->id > 0) {
                    return $this->redirect(['update', 'id' => $user->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $model = $this->findAdmin($id);
        $model->role = Admin::ROLE_USER;
        if ($model->isRemovable() && $model->remove()) {
            return Yii::$app->request->isAjax ? $this->success('删除成功') : $this->redirect(['index']);
        }
        return Yii::$app->request->isAjax ? $this->error('删除失败，该用户不允许被删除！') : $this->redirect(['index']);
    }

    /**
     * Displays a single Assignment model.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
            'idField' => $this->idField,
            'usernameField' => $this->usernameField,
            'fullnameField' => $this->fullnameField,
        ]);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->assign($items);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionRevoke($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->revoke($items);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return Assignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $class = $this->userClassName;
        if (($user = $class::findIdentity($id)) !== null) {
            return new Assignment($id, $user);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return Admin
     * @throws NotFoundHttpException
     */
    protected function findAdmin($id)
    {
        $class = $this->userClassName;
        if (($user = $class::findIdentity($id)) !== null) {
            return $user;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
