<?php

namespace admin\controllers\system;

use Yii;
use common\models\system\Application;
use admin\models\system\Application as ApplicationSearch;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\base\Controller;


/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        return $behaviors;
    }

    /**
     * Lists all Application models.
     * @return mixed
     */
    public function actionIndex()
    {
        // 内置数据也写入数据库，初始化时进行设置，可以编辑删除，但是可能会造成错误
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Application();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionAjaxUpdate()
    {
        if(!Yii::$app->request->isAjax)
            throw new BadRequestHttpException('非法请求');
        if (Yii::$app->request->post('hasEditable')) {
            return $this->ajax($this->editableUpdate());
        }
        return $this->ajax($this->editableUpdate());

    }
    public function editableUpdate()
    {
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = $this->findModel($id);
            $post = [];
            $posted = current(Yii::$app->request->post($model->formName()));
            $post[$model->formName()] = $posted;
            $output = '';$message='';
            if ($model->load($post)) {
                if($model->save() === false){
                    //if(isset($posted['name'])) $message = '修改失败！';
                    if(isset($posted['name'])) $message = $model->getFirstError('name');
                    if(isset($posted['identifier'])) $message = $model->getFirstError('identifier');
                    if(isset($posted['host'])) $message = $model->getFirstError('host');
                    if(isset($posted['ip'])) $message = $model->getFirstError('ip');
                }

                if (isset($posted['status'])) {
                    $output =  Yii::$app->formatter->asLookup($model->status, 'status');
                }
            }
            $res = ['output'=>$output, 'message'=>$message];

            return $res;
        }
    }

    /**
     * Deletes an existing Application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
