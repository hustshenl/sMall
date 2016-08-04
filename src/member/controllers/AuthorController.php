<?php

namespace member\controllers;

use common\behaviors\AjaxReturnBehavior;
use common\components\Image;
use common\models\access\User;
use yii;
use common\models\comic\Author;
use member\models\comic\Author as AuthorSearch;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
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
     * Lists all Author models.
     * @return mixed
     */
    public function actionIndex()
    {
        return 'error';
    }

    /**
     * 进行作者认证
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionAuth()
    {
        if (Yii::$app->user->identity->canAuthAuthor == false) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', '认证作者前请完善个人资料！真实姓名/身份证号/QQ/电话/联系地址'));
            return $this->redirect('/account/edit');
        }
        $authorId = Yii::$app->user->identity->author_id;
        if ($authorId > 0) {
            $model = $this->findModel($authorId);
            if($model === null) throw new BadRequestHttpException('没有找到认证信息，请联系管理员！');
        } else {
            $model = new Author();
        }
        if ($model->status == Author::STATUS_APPROVED) {
            return $this->render('view', [
                'model' => $model,
            ]);
        } elseif ($model->status == Author::STATUS_REJECTED) {
            Yii::$app->getSession()->setFlash('error', Yii::t('common', '管理员拒绝了您的申请，请修复申请资料后联系客服重新审核。'));
        }
        if ($model->load(Yii::$app->request->post()) && $model->auth(Yii::$app->user->id)) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', '认证申请成功，请等待管理员审核。'));
        }
        return $this->render('auth', [
            'model' => $model,
        ]);
    }

    public function actionNotice()
    {
        $model = $this->findModel(Yii::$app->user->identity->author_id);
        if($model === null) return $this->redirect(['auth']);
        $model->scenario = 'notice';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('common', '公告修改成功！'));
            //return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('notice', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Author|null the loaded model
     */
    protected function findModel($id)
    {
        return Author::findOne($id);
    }
}
