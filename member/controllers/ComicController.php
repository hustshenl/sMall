<?php

namespace member\controllers;

use common\behaviors\AjaxReturnBehavior;
use common\models\base\Category;
use common\models\access\User;
use yii;
use common\models\comic\Comic;
use member\models\comic\Comic as ComicSearch;
use common\components\Comic as ComicService;
use common\components\Cover as CoverService;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ComicController implements the CRUD actions for Comic model.
 */
class ComicController extends Controller
{
    static $nextTab = [
        'general' => 'meta',
        'meta' => 'cover',
        'cover' => 'category',
        'category' => 'tags',
        'tags' => 'etc',
        'etc' => 'view',
    ];

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

    public function beforeAction($action)
    {
        if (Yii::$app->user->identity->authorStatus != User::AUTHOR_ACTIVE) {
            Yii::trace(true);
            return $this->redirect('/author/auth')&&false;
        }
        Yii::trace(false);
        return parent::beforeAction($action);
    }

    /**
     * Lists all Comic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComicSearch(['scenario' => 'search_author']);
        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams, [$searchModel->formName() => [
            'author_id' => Yii::$app->user->identity->author_id,
            'status'=>Yii::$app->request->get('status', '')
        ]]));
        return $this->render('index', [
            'categories' => Category::categoriesArray(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comic model.
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
     * Creates a new Comic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $id int
     * @return mixed
     */
    public function actionCreate()
    {
        $service = new ComicService();
        if ($service->authorCreate()) {
            return $this->redirect(['create-cover', 'id' => $service->model->id]);
        }
        if (!empty($service->firstError)) Yii::$app->getSession()->setFlash('error', $service->firstError);
        return $this->render('create', [
            'model' => $service->model,
        ]);
    }

    public function actionCreateCover($id)
    {
        $model = $this->findModel($id);
        if (!empty($model->cover)) {
            Yii::$app->getSession()->setFlash('error', '已经存在封面！');
            $this->redirect(['/chapter/create', 'comic_id' => $model->id]);
        }
        $service = new ComicService(['model' => $model]);
        if ($service->createCover()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Create cover success!'));
            return $this->redirect(['/chapter/create', 'comic_id' => $model->id]);
        } elseif (Yii::$app->request->isPost) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', 'Create cover failed!'));
        }
        return $this->render('create-cover', [
            'model' => $model,
        ]);
    }
    public function actionUpdateCover($id)
    {
        $model = $this->findModel($id);
        $service = new ComicService(['model' => $model]);
        if ($service->createCover()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Update cover success!'));
        } elseif (Yii::$app->request->isPost) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', 'Update cover failed!'));
        }
        return $this->render('update-cover', [
            'model' => $model,
        ]);
    }

    public function actionCreated($id)
    {
        $model = $this->findModel($id);
        if (empty($model->cover)) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', '请上传封面!'));
            $this->redirect(['/comic/create-cover', 'id' => $model->id]);
        }
        if ($model->post_num <= 0) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', '请上传章节!'));
            $this->redirect(['/chapter/create', 'comic_id' => $model->id]);
        }
        return $this->render('created', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Comic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //if($this->isComplete($id)) return '';
        $tab = Yii::$app->request->post('tab', 'general');
        $model = $this->findModel($id);
        if (empty($model->cover)) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', '请上传封面!'));
            $this->redirect(['/comic/create-cover', 'id' => $model->id]);
        }
        if ($model->post_num <= 0) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', '请上传章节!'));
            $this->redirect(['/chapter/create', 'comic_id' => $model->id]);
        }
        $service = new ComicService(['model' => $model]);
        if ($service->authorUpdate()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Update success!'));
        }
        return $this->render('update', [
            'model' => $model,
        ]);
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
            //$model = Comic::findOne($id);
            $model = $this->findModel($id);
            //$res =['output'=>'', 'message'=>''];
            $post = [];
            $posted = current(Yii::$app->request->post($model->formName()));
            $post[$model->formName()] = $posted;
            $output = '';
            $message = '';
            if (isset($posted['status']) && $posted['status'] == Comic::STATUS_APPROVED) {
                $service = new ComicService(['model' => $model]);
                if ($service->approve()) {
                    $output = Yii::$app->formatter->asLookup($posted['status'], 'commendStatus');
                } else {
                    $message = '审核失败！';
                }
            } else if ($model->load($post)) {
                if ($model->save() === false) {
                    //if(isset($posted['name'])) $message = '修改失败！';
                    if (isset($posted['name'])) $message = $model->getFirstError('name');
                    if (isset($posted['slug'])) $message = $model->getFirstError('slug');
                }
                if (isset($posted['status'])) {
                    $output = Yii::$app->formatter->asLookup($model->status, 'approveStatus');
                }
                if (isset($posted['serialise'])) {
                    $output = Yii::$app->formatter->asLookup($model->serialise, 'serialise');
                }
                if (isset($posted['category'])) {
                    $output = Yii::$app->formatter->asLookup($model->category, Category::categoriesArray());
                }
                if (isset($posted['commend'])) {
                    $output = Yii::$app->formatter->asLookup($model->commend, 'commendStatus');
                }
            }
            $res = ['output' => $output, 'message' => $message];

            return $res;
        }
    }

    public function actionAjaxBatchOperation()
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $action = Yii::$app->request->post('action', false);
        if (!in_array($action, ['approve', 'commend', 'finish', 'serialise', 'delete'])) throw new BadRequestHttpException('非法请求');
        //return $this->{$action}();
        return call_user_func([static::className(), 'batch' . ucfirst($action)]);
    }

    public function batchApprove()
    {
        $ids = Yii::$app->request->post('ids', []);
        $res = true;
        foreach ($ids as $id) {
            $service = new ComicService(['model' => $this->findModel($id)]);
            $res = $service->approve() ? $res : false;
        }
        if ($res) return $this->success('操作成功');
        return $this->error('操作失败');
    }

    public function batchCommend()
    {
        $ids = Yii::$app->request->post('ids', []);
        $res = true;
        foreach ($ids as $id) {
            $model = $this->findModel($id);
            $model->commend = Comic::STATUS_COMMEND;
            $res = $model->save() ? $res : false;
        }
        if ($res) return $this->success('操作成功');
        return $this->error('操作失败');
    }

    public function batchFinish()
    {
        $ids = Yii::$app->request->post('ids', []);
        $res = true;
        foreach ($ids as $id) {
            $model = $this->findModel($id);
            $model->serialise = Comic::STATUS_FINISHED;
            $res = $model->save() ? $res : false;
        }
        if ($res) return $this->success('操作成功');
        return $this->error('操作失败');
    }

    public function batchSerialise()
    {
        $ids = Yii::$app->request->post('ids', []);
        $res = true;
        foreach ($ids as $id) {
            $model = $this->findModel($id);
            $model->serialise = Comic::STATUS_SERIALISE;
            $res = $model->save() ? $res : false;
        }
        if ($res) return $this->success('操作成功');
        return $this->error('操作失败');
    }

    public function batchDelete()
    {
        $ids = Yii::$app->request->post('ids', []);
        $res = true;
        foreach ($ids as $id) {
            $service = new ComicService(['model' => $this->findModel($id)]);
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
        }
        if ($res) return Yii::$app->request->isAjax ? $this->success('操作成功') : $this->redirect(['index']);
        return Yii::$app->request->isAjax ? $this->error('操作失败') : $this->redirect(['index']);
    }

    public function actionApplyCover($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $service = new ComicService();
        $service->model = $this->findModel($id);
        $image_id = Yii::$app->request->post('image_id', 0);
        if ($service->applyCover($image_id)) {
            if (Yii::$app->request->isAjax) {
                return $this->success('更新成功');
            } else {
                return '非法请求';
            }
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->error('更新失败');
            } else {
                return '非法请求';
            }
        }
    }

    public function actionApproveCover($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $service = new ComicService();
        $service->model = $this->findModel($id);
        $image_id = Yii::$app->request->post('image_id', 0);
        if ($service->approveCover($image_id)) {
            if (Yii::$app->request->isAjax) {
                return $this->success('更新成功');
            } else {
                return '非法请求';
            }
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->error('更新失败');
            } else {
                return '非法请求';
            }
        }
    }

    /**
     * 移除当前封面
     * @param $id
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionRemoveCover($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $service = new ComicService();
        $service->model = $this->findModel($id);
        if ($service->removeCover()) {
            if (Yii::$app->request->isAjax) {
                return $this->success('更新成功');
            } else {
                return '非法请求';
            }
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->error('更新失败');
            } else {
                return '非法请求';
            }
        }
    }

    /**
     * 删除封面图片
     * @param $id
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionRemoveImage($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $service = new ComicService();
        $service->model = $this->findModel($id);
        $image_id = Yii::$app->request->post('image_id', 0);
        if ($service->removeImage($image_id)) {
            if (Yii::$app->request->isAjax) {
                return $this->success('更新成功');
            } else {
                return '非法请求';
            }
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->error('更新失败');
            } else {
                return '非法请求';
            }
        }
    }

    /**
     * Deletes an existing Comic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        //$model = $this->findModel($id);
        $service = new ComicService(['model' => $this->findModel($id)]);
        if ($service->delete()) {
            return Yii::$app->request->isAjax ? $this->success('删除成功') : $this->redirect(['index']);
        }
        return Yii::$app->request->isAjax ? $this->error('删除失败') : $this->redirect(['index']);
        //$this->findModel($id)->delete();
    }

    public function actionRefresh($id)
    {
        if (!Yii::$app->request->isPost) throw new BadRequestHttpException('非法请求');
        $this->findModel($id)->save();
        return Yii::$app->request->isAjax ? $this->success('刷新成功') : $this->redirect(['index']);
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
        if (($model = Comic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
