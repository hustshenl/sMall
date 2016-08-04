<?php
namespace backend\controllers;

use common\migrations\m160101_000001_rbac_init;
use common\migrations\m160101_000002_create_db;
use common\migrations\m160101_000003_init_category;
use common\migrations\m160101_000004_init_scheduler;
use yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class InstallController extends Controller
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
                        'actions' => ['logout', 'index'],
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
        $lock = Yii::getAlias('@backend/runtime') . '/install.lock';
        if (file_exists($lock)) return $this->render('installed');
        return $this->render('index');
    }

    /**
     * 第一步，创建数据库
     * @return \yii\web\Response
     */
    public function actionCreateDb()
    {
        $m = new m140506_102106_rbac_init();
        $m->up();
        $m = new m160101_000002_create_db();
        $m->up();
        return $this->redirect('init-category');
    }

    /**
     * 第二步初始化分类信息，
     * @return \yii\web\Response
     */
    public function actionInitCategory()
    {
        $m = new m160101_000003_init_category();
        $m->up();
        return $this->redirect('init-scheduler');
    }
    /**
     * 第三步初始化定时任务信息，
     * @return \yii\web\Response
     */
    public function actionInitScheduler()
    {
        $m = new m160101_000004_init_scheduler();
        $m->up();
        return $this->redirect('finish');
    }
    public function actionFinish()
    {
        $lock = Yii::getAlias('@backend/runtime') . '/install.lock';
        if (!file_exists($lock)) {
            $fp = fopen($lock,'w');
            fwrite($fp,Sinmh::versionName());
        }
        return $this->render('finish');
    }


    /**
     * Creates a new migration instance.
     * @param string $class the migration class name
     * @param string $migrationPath the migration class name
     * @return \yii\db\Migration the migration instance
     */
    protected function createMigration($class,$migrationPath=false)
    {
        if($migrationPath){
            $file = $migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
            require_once($file);

        }

        return new $class(['db' => $this->db]);
    }
}
