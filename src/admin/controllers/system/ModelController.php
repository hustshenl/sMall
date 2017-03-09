<?php

namespace admin\controllers\system;

use Yii;
use common\models\system\Model;
use admin\models\system\ModelSearch as ModelSearch;
use common\models\system\ModelAttribute;
use admin\models\system\ModelAttribute as ModelAttributeSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\base\Controller;


/**
 * ModelController implements the CRUD actions for Model model.
 */
class ModelController extends Controller
{
    public $renderer = 'render';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] =  [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['post'],
            ],
        ];
        return $behaviors;
    }

    public function init()
    {
        if(Yii::$app->request->isAjax)
        $this->renderer = 'renderAjax';
        parent::init();
    }

    /**
     * Lists all Model models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModelSearch();
        $formName = Yii::$app->request->isAjax ? '' : $searchModel->formName();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$formName);
        return Yii::$app->request->isAjax&&Yii::$app->request->get('_pjax',false) === false?$this->success($dataProvider, 'results') :$this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Model model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new ModelAttributeSearch();
        $dataProvider = $searchModel->search(['model_id'=>$id],'');
        return $this->{$this->renderer}('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Creates a new Model model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Model();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->{$this->renderer}('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Model model.
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
            return $this->{$this->renderer}('update', [
                'model' => $model,
            ]);
            /*return $this->render('update', [
                'model' => $model,
            ]);*/
        }
    }
    public function actionValidate($id=0)
    {
        $model = new Model();
        if($id>0) $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        return $this->success(\yii\widgets\ActiveForm::validate($model));
    }

    public function actionAttributeView($id)
    {
        $model = $this->findAttribute($id);
        return $this->{$this->renderer}('attribute-view', [
            'model' => $model,
        ]);

    }
    public function actionAttributeCreate($id)
    {
        $model = new ModelAttribute();
        $model->model_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->model_id]);
        } else {
            return $this->{$this->renderer}('attribute-create', [
                'model' => $model,
            ]);
        }
    }
    public function actionAttributeUpdate($id)
    {
        $model = $this->findAttribute($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->model_id]);
        } else {
            return $this->{$this->renderer}('attribute-update', [
                'model' => $model,
            ]);
        }
    }
    public function actionAttributeValidate($id=0,$model_id)
    {
        $model = new ModelAttribute();
        $model->model_id = $model_id;
        if($id>0) $model = $this->findAttribute($id);
        $model->load(Yii::$app->request->post());
        return $this->success(\yii\widgets\ActiveForm::validate($model));
    }



    /**
     * Deletes an existing Model model.
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
     * Finds the Model model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Model the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAttribute($id)
    {
        if (($model = ModelAttribute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
