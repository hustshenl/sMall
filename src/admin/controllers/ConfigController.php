<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/17 16:46
 * @Description:
 */

namespace admin\controllers;



use common\components\Config;
use yii\web\Controller;
use admin\models\configs\BaseConfig;
use admin\models\configs\OperationForm;
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

    /**
     * 系统设置首页
     */
    public function actionIndex()
    {
        $model = new BaseConfig();
        $model->attributes = $this->_config->get("siteInfo");
        if ($model->load(Yii::$app->request->post())) {
            $this->_config->set("siteInfo", $model->attributes);
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Save success!'));
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionOperation()
    {
        $model = new OperationForm();
        $model->attributes = $this->_config->get("operationInfo");
        if ($model->load(Yii::$app->request->post())) {
            $this->_config->set("operationInfo", $model->attributes);
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'Save success!'));
            return $this->refresh();
        }
        return $this->render('operation', [
            'model' => $model,
        ]);
    }

    /**
     * ajax进行区域操作的动作
     */
    public function actionAreaAjax()
    {
        $post = Yii::$app->request->post();
        $id = (int)$post['id'];
        if (isset($post['ac'])) {
            switch ($post['ac']) {
                case 'edit':
                    $name = $post['name'];
                    $sort = $post['sort'];
                    if (($updateResult = Area::mybeUpdate($id, ['name' => $name, 'sort' => $sort])) && ($updateResult === true)) {
                        //更新成功
                        return json_encode(['status' => 1, 'msg' => 'success', 'data' => '更新成功']);
                    } else {
                        //更新失败
                        return $this->returnAjax($updateResult, 0);
                    }

                    break;
                case 'delete':  //删除
                    //当前分类是否存在子分类
                    if (($deleteResult = Area::canDelete($id)) && ($deleteResult === true)) {
                        return json_encode(['status' => 1, 'msg' => 'success', 'data' => "删除成功"]);
                    } else {
                        return $this->returnAjax($deleteResult, 0);
                    }
                    break;
                case 'add': //添加子分类
                    $name = $post['name'];
                    $sort = $post['sort'];
                    if (empty($name)) return $this->returnAjax("error", 0, "请输入名称");
                    if (Area::canAddChild($id)) {
                        if (Area::nameIsUnique($name, $id) !== false) {
                            return $this->returnAjax('error', 0, "分类名称已经被使用");
                        }
                        if ($addResults = Area::addArea([
                            'name' => trim($name),
                            'sort' => (int)$sort,
                            'pid' => $id
                        ])
                        ) {
                            return $this->returnAjax('success', 1, '分类添加成功');
                        } else {
                            return $this->returnAjax('error', 0, '分类添加失败');
                        }
                    } else {
                        return $this->returnAjax('error', 0, '暂时不支持为二级分类添加子分类');
                    }
                    break;
            }
        }
    }


}