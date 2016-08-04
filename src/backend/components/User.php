<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components;

use yii;
use yii\web\IdentityInterface;

class User extends \yii\web\User
{
    protected function renewAuthStatus()
    {
        if(Yii::$app->session->get('accessed') === true){
            /* @var $class IdentityInterface */
            $class = $this->identityClass;
            $identity = $class::findIdentity(0);
            $this->setIdentity($identity);
        }
        return true;
    }
}
