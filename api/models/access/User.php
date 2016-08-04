<?php

namespace api\models\access;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\access\User as UserMode;;

/**
 * User represents the model behind the search form about `common\models\access\User`.
 */
class User extends UserMode
{

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if(empty($token)) return false;
        return static::findOne(['auth_key' => $token]);
    }
}
