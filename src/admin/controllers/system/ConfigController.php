<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/17 16:46
 * @Description:
 */

namespace admin\controllers\system;


use admin\models\system\configs\MallConfig;
use common\components\base\Config;
use yii\web\Controller;
use admin\models\system\configs\SystemConfig;
use admin\models\system\configs\RsaConfig;
use yii;

class ConfigController extends Controller
{

    /** @var  Config */
    private $_config;

    public function init()
    {
        parent::init();
        $this->_config = Yii::$app->config;
    }

    public function actions()
    {
        return parent::actions();
    }

    /**
     * @return string|yii\web\Response
     */
    public function actionIndex()
    {
        return $this->_config('system', new SystemConfig());
    }

    public function actionRsa()
    {
        return $this->_config('rsa', new RsaConfig());
    }

    public function actionMall()
    {
        return $this->_config('mall', new MallConfig());
    }

    /**
     * @param $category string
     * @param $model yii\base\Model
     * @return string|yii\web\Response
     */
    private function _config($category, $model)
    {
        //$model = new BaseConfig();
        $model->attributes = $this->_config->get($category);
        if ($model->load(Yii::$app->request->post())) {
            $this->_config->set($category, $model->attributes);
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Save success!'));
            return $this->refresh();
        }
        return $this->render($category, [
            'model' => $model,
        ]);
    }


}