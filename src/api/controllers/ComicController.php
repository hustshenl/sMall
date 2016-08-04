<?php
namespace api\controllers;


use common\models\comic\Comic;
use api\models\comic\Comic as ComicSearch;
use yii;
use api\components\RestController;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ComicController extends RestController
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'only'=>['option','score'],
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['httpCache'] = [
            'class' => 'yii\filters\HttpCache',
            'only' => ['index'],
            'lastModified' => function ($action, $params) {
                return strtotime(date('Y-m-d H:00:00'));
            },
            'cacheControlHeader' => 'public, max-age=3600',
        ];
        $behaviors['pageCache']= [
            'class' => 'yii\filters\PageCache',
            'only' => ['index','search','update','rank','search','search'],
            'duration' => 3600,
            'variations' => [
                Yii::$app->language,
                Yii::$app->request->queryParams,
            ],
            'enabled'=>Yii::$app->request->isGet,
        ];
        return $behaviors;
    }

    public function actionTest()
    {
        return $this->success('test');
    }

    public function actionSearch()
    {
        $searchModel = new ComicSearch(['scenario'=>'search']);
        $param = $this->param;
        $dataProvider = $searchModel->search(['keywords'=>$param['keywords']],'');
        $this->serializer['scenario'] = 'api_search';
        return $this->success($dataProvider);
    }

    public function actionClick()
    {
        $comic_id = ArrayHelper::getValue($this->param,'comic_id',0);
        $model = $this->findModel($comic_id);
        if($model == false) return $this->error('没有找到指定漫画！');
        if($model->updateClick()) return $this->success('操作成功！');
        return $this->error('操作失败！');
    }
    public function actionPopularity()
    {
        $comic_id = ArrayHelper::getValue($this->param,'comic_id',0);
        $model = $this->findModel($comic_id);
        if($model == false) return $this->error('没有找到指定漫画！');
        if($model->updatePopularity()) return $this->success('操作成功！');
        return $this->error('操作失败！');
    }

    public function actionOption()
    {
        $comic_id = ArrayHelper::getValue($this->param,'comic_id',0);
        $model = $this->findModel($comic_id);
        if($model == false) return $this->error('没有找到指定漫画！');
        if($model->updateOption(ArrayHelper::getValue($this->param,'option','praise'))) return $this->success('操作成功！');
        return $this->error('操作失败！');
    }
    public function actionScore()
    {
        $comic_id = ArrayHelper::getValue($this->param,'comic_id',0);
        $model = $this->findModel($comic_id);
        if($model == false) return $this->error('没有找到指定漫画！');
        if($model->updateScores(ArrayHelper::getValue($this->param,'star',5))) return $this->success('操作成功！');
        return $this->error('操作失败！');
    }

    /**
     * Finds the Comic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comic::findOne(['id'=>$id,'status'=>Comic::STATUS_APPROVED])) !== null) {
            return $model;
        } else {
            return false;
            throw new NotFoundHttpException('Invalid Comic.');
        }
    }


}