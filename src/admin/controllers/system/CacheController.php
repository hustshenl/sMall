<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/17 16:46
 * @Description:
 */

namespace admin\controllers\system;



use yii\web\Controller;

use admin\models\forms\Cache as CacheForm;
use yii;

class CacheController extends Controller
{



    /**
     *  清理缓存首页
     */
    public function actionIndex()
    {
        $model = new CacheForm();
        if ($model->load(Yii::$app->request->post())) {
            // 在此清理缓存
            if($model->all) $model->parts = [
                'hust.shenl.small.passport.page.javascript',
                'hust.shenl.small.main.page.javascript',
            ];
            if(is_array($model->parts)&&count($model->parts)>0){
                foreach ($model->parts as $part){
                    yii\caching\TagDependency::invalidate(Yii::$app->cache,$part);
                }
                Yii::$app->getSession()->setFlash('success', Yii::t('common', '缓存清理成功!'));
            }else{
                Yii::$app->getSession()->setFlash('error', Yii::t('common', '没有选择任何缓存!'));
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
