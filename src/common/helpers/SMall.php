<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/3/24 14:15
 * @Description:
 */

namespace common\helpers;


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
     * @param $app
     * @return string
     */
    public static function getHost($app)
    {
        if(in_array($app,['resource','passport'])){
            return call_user_func([static::className(),'get'.ucfirst($app).'Host']);
        }
        return null;
    }
    public static function getResourceHost()
    {
        return '//res.small.dev.com';
    }
    public static function getPassportHost()
    {
        return '//passport.small.dev.com';
    }

}