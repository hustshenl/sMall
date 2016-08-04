<?php
namespace api\controllers\user;


use common\models\member\Subscribe;
use api\models\member\Subscribe as SubscribeSearch;
use yii;
use api\components\RestController;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class SubscribeController extends RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except' => ['token'],
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        return $behaviors;
    }

    public function actionIndex($id = 0)
    {
        $searchModel = new SubscribeSearch();
        $dataProvider = $searchModel->search([$searchModel->formName() => ['user_id' => Yii::$app->user->id, 'type' => Subscribe::TYPE_SUBSCRIBE]]);
        $this->serializer['scenario'] = 'subscribe';
        return $this->success($dataProvider);
    }


    /**
     * 添加订阅
     * @return array
     */
    public function actionAdd()
    {
        $this->serializer['collectionEnvelope'] = 'data';
        $comic_id = ArrayHelper::getValue($this->param, 'comic_id', 0);
        $model = $this->findModel($comic_id);
        if ($model) return $this->error('您已经订阅这本漫画！');
        $model = new Subscribe(['type' => Subscribe::TYPE_SUBSCRIBE,'scenario'=>'subscribe']);
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $this->success(['data' => $model]);
        }
        return $this->error('添加订阅失败！');
    }

    public function actionDelete()
    {
        $model = $this->findModel(ArrayHelper::getValue($this->param,'comic_id'));
        if($model == false) return $this->error('您并未订阅该漫画！');
        if($model->delete()){
            return $this->success('删除成功！');
        }
        return $this->success('删除失败！');
    }


    /**
     * Finds the CouponSet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subscribe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscribe::findOne(['comic_id' => $id, 'type' => Subscribe::TYPE_SUBSCRIBE, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        } else {
            return false;
        }
    }

}