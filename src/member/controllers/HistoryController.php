<?php

namespace member\controllers;

use common\behaviors\AjaxReturnBehavior;
use yii;
use common\models\member\Subscribe;
use member\models\member\Subscribe as SubscribeSearch;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SubscribeController implements the CRUD actions for Subscribe model.
 */
class HistoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'clear' => ['post'],
                ],
            ],
            [
                'class' => AjaxReturnBehavior::className()
            ],
        ];
    }

    /**
     * Lists all Subscribe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubscribeSearch();
        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams,[$searchModel->formName()=>['user_id'=>Yii::$app->user->id,'type'=>Subscribe::TYPE_HISTORY]]));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdated()
    {
        $searchModel = new SubscribeSearch();
        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams,[$searchModel->formName()=>['user_id'=>Yii::$app->user->id, 'status'=>Subscribe::STATUS_UNREAD,'type'=>Subscribe::TYPE_HISTORY]]));

        return $this->render('updated', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionClear()
    {
        if(Subscribe::clear(Yii::$app->user->id,Subscribe::TYPE_HISTORY)){
            Yii::$app->session->setFlash('success', '清除成功！');
        }else{
            Yii::$app->session->setFlash('error', '清除失败！');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Deletes an existing Subscribe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
            Yii::$app->session->setFlash('success', '删除成功！');
        }else{
            Yii::$app->session->setFlash('error', '删除失败！');

        }
        return $this->redirect(Yii::$app->request->referrer);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    public function actionResolve($id)
    {

        if($this->findModel($id)->resolve()){
            Yii::$app->session->setFlash('success', '标记成功！');
        }else{
            Yii::$app->session->setFlash('error', '标记失败！');

        }
        return $this->redirect(Yii::$app->request->referrer);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Subscribe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subscribe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscribe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
