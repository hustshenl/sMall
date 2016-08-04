<?php
namespace api\controllers;

use common\models\comic\Chapter;
use common\models\member\Subscribe;
use api\models\member\Subscribe as SubscribeSearch;
use yii;
use api\components\RestController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class HistoryController extends RestController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except' => ['add'],
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'clear' => ['post'],
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
        $behaviors['pageCache'] = [
            'class' => 'yii\filters\PageCache',
            'only' => ['index', 'search', 'update', 'rank', 'search', 'search'],
            'duration' => 3600,
            'variations' => [
                Yii::$app->language,
                Yii::$app->request->queryParams,
            ],
            'enabled' => Yii::$app->request->isGet,
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $searchModel = new SubscribeSearch();
        $dataProvider = $searchModel->search([$searchModel->formName() => ['user_id' => Yii::$app->user->id, 'type' => Subscribe::TYPE_HISTORY]]);
        $this->serializer['scenario'] = 'history';
        return $this->success($dataProvider);
    }


    /**
     * 添加历史纪录
     * @return array
     */
    public function actionAdd()
    {
        $this->serializer['collectionEnvelope'] = 'data';
        if ($this->login() == false) return $this->success(['data' => $this->guestHistory]);
        $comic_id = ArrayHelper::getValue($this->param, 'comic_id', 0);
        $model = $this->fetchHistory($comic_id);
        $model->scenario = 'history';
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $this->success(['data' => $model]);
        }
        Yii::trace($model->errors);
        return $this->error('添加失败');
    }

    /**
     * 获取游客阅读记录数据
     * @return array
     * @throws NotFoundHttpException
     */
    protected function getGuestHistory()
    {
        /**
         * @var Chapter $chapter
         */
        $chapter_id = ArrayHelper::getValue($this->param, 'read_chapter_id', 0);
        $chapter = $this->findChapter($chapter_id);
        return [
            'comic_id' => $chapter->comic_id,
            'comic_name' => $chapter->comic_name,
            'comic_url' => $chapter->comicUrl,
            'comic_cover' => $chapter->comic->coverUrl,
            'read_at' => time(),
            'read_chapter' => $chapter->name,
            'read_chapter_id' => $chapter->id,
            'read_chapter_url' => $chapter->url,
            'read_page' => Yii::$app->request->post('page', 1),
        ];
    }

    public function actionDelete()
    {
        $comic_id = ArrayHelper::getValue($this->param, 'comic_id', 0);
        $model = $this->findModel($comic_id);
        if (!$model || $model->delete()) {
            return $this->success('删除成功！');
        } else {
            return $this->success('删除失败！');
        }
    }

    public function actionClear()
    {
        if (Subscribe::deleteAll(['type' => Subscribe::TYPE_HISTORY, 'user_id' => Yii::$app->user->id]) >= 0) {
            return $this->success('清空成功！');
        } else {
            return $this->success('清空失败！');
        }
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
        if (($model = Subscribe::findOne(['comic_id' => $id, 'type' => Subscribe::TYPE_HISTORY, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        } else {
            return false;
        }
    }

    protected function fetchHistory($id)
    {
        $model = $this->findModel($id);
        if ($model) return $model;
        return new  Subscribe(['type' => Subscribe::TYPE_HISTORY]);

    }

    protected function findChapter($id)
    {
        if (($model = Chapter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Subscribe Not Found.');
        }
    }

}