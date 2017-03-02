<?php

namespace admin\controllers\store;

use Yii;
use common\models\store\Certification;
use common\models\store\CertificationItem;
use admin\models\store\Certification as CertificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use admin\models\store\CertificationItem as CertificationItemSearch;

/**
 * CertificationController implements the CRUD actions for Certification model.
 */
class CertificationController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Certification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CertificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Certification model.
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
     * Creates a new Certification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Certification();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Certification model.
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

    /**
     * Deletes an existing Certification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionItem($id)
    {
        $model = $this->findModel($id);
        $searchModel = new CertificationItemSearch();
        $dataProvider = $searchModel->search(['certification_id'=>$id]);
        return $this->render('item', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionItemCreate($id)
    {
        $certification = $this->findModel($id);
        $model = new CertificationItem();
        $model->certification_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['item', 'id' => $id]);
        } else {
            return Yii::$app->request->isAjax? $this->renderAjax('item-create', [
                'certification'=>$certification,
                'model' => $model,
            ]):$this->render('item-create', [
                'certification'=>$certification,
                'model' => $model,
            ]);
        }
    }

    public function actionItemUpdate($id)
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

    public function actionItemDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    /**
     * Finds the Certification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Certification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Certification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findItem($id)
    {
        if (($model = CertificationItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
