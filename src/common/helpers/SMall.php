<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/3/24 14:15
 * @Description:
 */

namespace common\helpers;


use common\models\system\Application;
use yii\base\Component;
use yii;

class SMall extends Component
{
    public static function versionName() {
        return '0.0.1';
    }

    public static function versionCode()
    {
        return 1;
    }

    /**
     * @param $identifier
     * @return string
     */
    public static function getHost($identifier)
    {
        $apps = Application::findAll(['status'=>Application::STATUS_APPROVED]);
        foreach ($apps as $app){
            if($app->identifier !== $identifier) continue;
            return $app->host;
        }
        return null;
    }
    public static function getResourceHost()
    {
        return static::getHost('app-resource');
    }
    public static function getPassportHost()
    {
        return static::getHost('app-passport');
    }

}