<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/5 21:02
 * @Description:
 */

namespace common\components;

use yii\base\Component;
use yii\web\NotFoundHttpException;
use yii;
use yii\web\BadRequestHttpException;
use yii\base\InvalidConfigException;
use Exception;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use common\models\access\User as UserModel;

/**
 * 用户服务
 * 提供注册/登陆/
 * @package common\components
 * @property string $firstError
 */
class User extends Component
{

    const EVENT_BEFORE_CREATE = 'beforeCreate';
    const EVENT_AFTER_CREATE = 'afterCreate';
    const EVENT_BEFORE_DELETE = 'beforeDelete';
    const EVENT_AFTER_DELETE = 'afterDelete';

    const CACHE_TAG_ACCESS_TOKEN = 'hust.shenl.small.sdk.access.token';
    const CACHE_TAG_VERSION = 'hust.shenl.small.sdk.version';
    const CACHE_TAG_LICENSE = 'hust.shenl.small.sdk.license';
    const CACHE_TAG_BEHAVIOR = 'hust.shenl.small.sdk.behavior';

    public $debug = false;
    public $errCode = 40001;
    public $errMsg = 'access denied!';
    public $cacheDuration = 6048002;

    /**
     * 用户工厂方法
     * @param $phone
     * @param $nickname
     * @return UserModel
     */
    public static function fetchUser($phone,$nickname=null)
    {
        $user = UserModel::findOne(['phone'=>$phone]);
        if($user == null) {
            $user = new UserModel();
            $user->phone = $phone;
            $user->username = 'phone:'.$phone;
            $user->nickname = $nickname ? $nickname : $phone;
            $user->setPassword(Yii::$app->security->generateRandomKey());
            $user->generateAuthKey();
            $user->save();
        }
        return $user;
    }


}