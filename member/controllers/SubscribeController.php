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
class SubscribeController extends Controller
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
                    'read-all' => ['post'],
                    'cancel' => ['post'],
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
        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams,[$searchModel->formName()=>['user_id'=>Yii::$app->user->id,'type'=>Subscribe::TYPE_SUBSCRIBE]]));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRead()
    {
        $searchModel = new SubscribeSearch();
        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams,[$searchModel->formName()=>['user_id'=>Yii::$app->user->id, 'status'=>Subscribe::STATUS_READ,'type'=>Subscribe::TYPE_SUBSCRIBE]]));

        return $this->render('read', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUnread()
    {
        $searchModel = new SubscribeSearch();
        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams,[$searchModel->formName()=>['user_id'=>Yii::$app->user->id, 'status'=>Subscribe::STATUS_UNREAD,'type'=>Subscribe::TYPE_SUBSCRIBE]]));

        return $this->render('unread', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReadAll()
    {
        if(Subscribe::readAll(Yii::$app->user->id,Subscribe::TYPE_SUBSCRIBE)){
            Yii::$app->session->setFlash('success', '成功全部标记为已读！');
        }else{
            Yii::$app->session->setFlash('error', '标记失败！');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * Deletes an existing Subscribe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCancel($id)
    {
        if($this->findModel($id)->delete()){
            Yii::$app->session->setFlash('success', '取消成功！');
        }else{
            Yii::$app->session->setFlash('error', '取消失败！');

        }
        return $this->redirect(Yii::$app->request->referrer);
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
