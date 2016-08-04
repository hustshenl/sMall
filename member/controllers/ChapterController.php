<?php

namespace member\controllers;

use common\behaviors\AjaxReturnBehavior;
use common\components\Upload;
use common\models\comic\ChapterCategory;
use member\models\comic\ChapterCategory as CategorySearch;
use common\models\comic\Comic;
use yii;
use common\models\comic\Chapter;
use member\models\comic\Chapter as ChapterSearch;
use common\components\Chapter as ChapterService;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ChapterController implements the CRUD actions for Chapter model.
 */
class ChapterController extends Controller
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
                ],
            ],
            [
                'class' => AjaxReturnBehavior::className()
            ],
        ];
    }

    /**
     * Lists all Chapter models.
     * @param $comic_id
     * @return string
     */
    public function actionIndex($comic_id)
    {
        $searchModel = new ChapterSearch();
        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams, [$searchModel->formName() => ['comic_id' => $comic_id]]));

        return $this->render('index', [
            'comic' => $this->findComic($comic_id),
            'categories' => ChapterCategory::categoriesArray(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chapter model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'comic' => $this->findComic($model->comic_id),

        ]);
    }

    /**
     * Creates a new Chapter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $comic_id
     * @return string|\yii\web\Response
     */
    public function actionCreate($comic_id)
    {
        $comic = $this->findComic($comic_id);
        $service = new ChapterService(['comic' => $comic]);
        if ($service->create()) {
            if (Yii::$app->request->post('isCreateComic', false))
                return $this->redirect(['/comic/created', 'id' => $comic_id]);
            return $this->redirect(['view', 'id' => $service->model->id]);
        } else {
            return $this->render($comic->post_num > 0||$comic->status != Comic::STATUS_CREATED ? 'create' : 'create_step', [
                'comic' => $comic,
                'model' => $service->model,
            ]);
        }
    }

    public function actionFileUpload()
    {
        $file = ChapterService::uploadImage(Yii::$app->request->post('basename', false));
        if ($file == false)
            return $this->error('文件上传错误');
        return $this->success(['data' => $file]);
    }

    public function actionFileDelete()
    {
        $basename = Yii::$app->request->post('basename');
        return $this->success(['data' => ['filename' => time() . '.jpg', 'path' => 'aa/bbb/' . $basename]]);
    }

    /**
     * Updates an existing Chapter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $service = new ChapterService(['model' => $model, 'comic' => $this->findComic($model->comic_id)]);

        if ($service->update()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'comic' => $this->findComic($model->comic_id),
                'model' => $model,
            ]);
        }
    }

    public function actionAjaxUpdate()
    {
        if (!Yii::$app->request->isAjax)
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
            /**
             * @var $model Comic
             */
            $model = $this->findModel($id);//Comic::findOne($id);
            $post = [];
            $posted = current(Yii::$app->request->post($model->formName()));
            $post[$model->formName()] = $posted;
            $output = '';
            $message = '';
            if (isset($posted['status']) && $posted['status'] == Comic::STATUS_APPROVED) {
                $service = new ChapterService(['model' => $model]);
                if ($service->approve()) {
                    $output = Yii::$app->formatter->asLookup($posted['status'], 'commendStatus');
                } else {
                    $message = '审核失败！';
                }
            } else if ($model->load($post)) {
                if ($model->save() === false) {
                    //if(isset($posted['name'])) $message = '修改失败！';
                    if (isset($posted['name'])) $message = $model->getFirstError('name');
                    if (isset($posted['sort'])) $message = $model->getFirstError('sort');
                }
                if (isset($posted['status'])) {
                    $output = Yii::$app->formatter->asLookup($model->status, 'approveStatus');
                }
                if (isset($posted['category'])) {
                    $output = Yii::$app->formatter->asLookup($model->category, ChapterCategory::categoriesArray());
                }
            }
            return ['output' => $output, 'message' => $message];
        }
    }

    public function actionAjaxBatchOperation()
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $action = Yii::$app->request->post('action', false);
        if (!in_array($action, ['approve', 'delete'])) throw new BadRequestHttpException('非法请求');
        //return $this->{$action}();
        return call_user_func([static::className(), 'batch' . ucfirst($action)]);
    }

    public function batchApprove()
    {
        $ids = Yii::$app->request->post('ids', []);
        $res = true;
        foreach ($ids as $id) {
            $service = new ChapterService(['model' => $this->findModel($id)]);
            $res = $service->approve() ? $res : false;
        }
        if ($res) return $this->success('操作成功');
        return $this->error('操作失败');
    }

    public function batchDelete()
    {
        $ids = Yii::$app->request->post('ids', []);
        $res = true;
        foreach ($ids as $id) {
            $service = new ChapterService(['model' => $this->findModel($id)]);
            $res = $service->delete() ? $res : false;
        }
        if ($res) return $this->success('操作成功');
        return $this->error('操作失败');
    }

    public function actionModifyCategory($cid)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $ids = Yii::$app->request->post('ids', []);
        $res = true;
        foreach ($ids as $id) {
            $model = $this->findModel($id);
            $model->category = $cid;
            $res = $model->save() ? $res : false;
            //$service = new ChapterService(['model'=>$this->findModel($id)]);
            //$res = $service->approve()? $res : false;
        }
        if ($res) return Yii::$app->request->isAjax ? $this->success('操作成功') : $this->redirect(['index']);
        return Yii::$app->request->isAjax ? $this->error('操作失败') : $this->redirect(['index']);
    }

    /**
     * Deletes an existing Chapter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $id
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $model = $this->findModel($id);
        $service = new ChapterService(['model' => $model, 'comic' => $this->findComic($model->comic_id)]);
        if ($service->delete()) {
            return Yii::$app->request->isAjax ? $this->success('删除成功') : $this->redirect(['index', 'comic_id' => $model->comic_id]);
        }
        return Yii::$app->request->isAjax ? $this->error('删除失败') : $this->redirect(['index', 'comic_id' => $model->comic_id]);
    }


    public function actionCategory()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = $this->findCategory($id);
            //$out = ['output'=>'', 'message'=>''];
            $post = [];
            $posted = current(Yii::$app->request->post($model->formName()));
            $post[$model->formName()] = $posted;
            $output = '';
            $message = '';
            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                if ($model->save() === false) {
                    if (isset($posted['name']))
                        $message = '修改失败！';
                    if (isset($posted['name'])) $message = $model->getFirstError('name');
                    if (isset($posted['sort'])) $message = $model->getFirstError('sort');
                }
                //$out = ['output'=>$output, 'message'=>$message];
            }
            return $this->ajax(['output' => $output, 'message' => $message]);
        }
        return $this->render('category', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategoryCreate()
    {
        $model = new ChapterCategory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['category']);
        } else {
            return $this->render('category-create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCategoryDelete($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $model = $this->findCategory($id);
        if ($model->isDeletable() && $model->delete()) {
            return Yii::$app->request->isAjax ? $this->success('删除成功') : $this->redirect(['category']);
        }
        return Yii::$app->request->isAjax ? $this->error('删除失败，分类章节数量不为0！') : $this->redirect(['category']);
    }


    /**
     * Finds the Chapter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chapter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chapter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return Comic
     * @throws NotFoundHttpException
     */
    protected function findComic($id)
    {
        if (($model = Comic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return ChapterCategory
     * @throws NotFoundHttpException
     */
    protected function findCategory($id)
    {
        if (($model = ChapterCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
