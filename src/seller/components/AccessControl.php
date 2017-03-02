<?php

namespace seller\components;

use yii\web\ForbiddenHttpException;
use yii\base\Module;
use yii;
use yii\web\User;
use yii\di\Instance;

class AccessControl extends \mdm\admin\components\AccessControl
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $user = $this->getUser();
        if(isset(Yii::$app->params['super_admin'])&&in_array( $user->id,(array)Yii::$app->params['super_admin'])) {
            return true;
        }
        return parent::beforeAction($action);
    }

}