<?php
namespace backend\controllers;

use backend\models\AdminForm;
use common\migrations\m160101_000001_rbac_init;
use common\migrations\m160101_000002_create_db;
use common\models\access\User;
use yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\access\LoginForm;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;


class ToolkitController extends Controller
{
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index','admin-add', 'admin-edit','execute-sql'],
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
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'model' => Yii::$app->user->identity,
        ]);
    }

    public function actionTest()
    {
        $m = new m160101_000002_create_db();
        $m->up();
        return 'ok';
    }

    /**
     * 初始化管理员
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionAdminAdd(){
        $model = User::findOne(['username'=>'Admin']);
        if($model != null) {
            throw new BadRequestHttpException('已经存在Admin账号');
        }
        $model = new AdminForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->add()) {
                if ($user->id > 0) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('common', '成功添加管理员!'));
                    //return $this->redirect(['site/success']);
                    return $this->redirect(['site/index']);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * 编辑管理员
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionAdminEdit()
    {
        /*$model = User::findOne(['username'=>'Admin']);
        if($model == null) {
            throw new BadRequestHttpException('不存在Admin账号');
        }
        $item = $model->getOldAttributes();
        $model = new  AdminForm([],$item);*/
        $model = $this->findAdminForm();
        //var_dump($model);exit;
        if ($model->load(Yii::$app->getRequest()->post())&&$model->edit()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'save success!'));
            //return $this->redirect(['site/success']);
        }
        return $this->render('update', ['model' => $model,]);
    }
    public function actionExecuteSql()
    {
        //if(!Yii::$app->request->isPost) throw new BadRequestHttpException('非法访问');
        $sql = Yii::$app->getRequest()->post('sql','');
        if(!empty($sql))
        {
            $db = Yii::$app->db;
            $command=$db->createCommand($sql);
            $result = $command->execute();
            /*$result = $command->queryAll();
            Yii::trace($result);
            Yii::trace($command->pdoStatement);
            var_dump($result);
            return;*/
            Yii::$app->getSession()->setFlash('success', "执行成功，影响了{$result}行");
            /*if($result>=0) {
                Yii::$app->getSession()->setFlash('success', "执行成功，影响了{$result}行");
            }else{
                Yii::$app->getSession()->setFlash('error', '执行');

            }*/
            //return $this->redirect(['site/success']);
        }
        /*if ($model->load(Yii::$app->getRequest()->post())&&$model->edit()) {
            return $this->redirect(['site/success']);
        }*/
        return $this->render('execute-sql');
    }

    /**
     * 初始化任务调度
     * @return \yii\web\Response
     */
    public function actionInitScheduler()
    {
        $sql = Yii::$app->getRequest()->post('sql','');
        $db = Yii::$app->db;
        $command=$db->createCommand($sql);
        $result = $command->execute();
        Yii::$app->getSession()->setFlash('success', "执行成功，影响了{$result}行");
        return $this->redirect('site/success');
    }
    protected function findAdminForm()
    {
        /**
         * @var $model User
         */
        $model = User::findOne(['username'=>'Admin']);
        if($model == NULL){
            throw new NotFoundHttpException('不存在Admin账号');
        }
        $item = $model->oldAttributes;
        return new  AdminForm([],$item);
    }
}
