<?php

namespace member\controllers;

use common\behaviors\AjaxReturnBehavior;
use common\components\Image;
use yii;
use common\models\base\Region;
use member\models\base\Region as RegionSearch;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RegionController implements the CRUD actions for Region model.
 */
class RegionController extends Controller
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
            ]
        ];
    }

    public function actionCity()
    {
        $ids = Yii::$app->request->post('depdrop_parents',[]);
        $pid = isset($ids[0])?$ids[0]:null;
        $searchModel = new RegionSearch();
        $dataProvider = $searchModel->search(ArrayHelper::merge(
            Yii::$app->request->queryParams,
            [
                $searchModel->formName() => [
                    'lvl' => 2,
                    'pid'=>$pid,
                ]
            ]
        ));
        return $this->success($dataProvider, 'output');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDistrict()
    {
        $ids = Yii::$app->request->post('depdrop_parents',[]);
        $pid = isset($ids[0])?$ids[0]:null;
        $searchModel = new RegionSearch();
        $dataProvider = $searchModel->search(ArrayHelper::merge(
            Yii::$app->request->queryParams,
            [
                $searchModel->formName() => [
                    'lvl' => 3,
                    'pid'=>$pid,
                ]
            ]
        ));
        return $this->success($dataProvider, 'output');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the Region model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Region the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Region::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
