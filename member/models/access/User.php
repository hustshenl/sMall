<?php

namespace member\models\access;

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
    public function behaviors()
    {
        return [];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'scores', 'grade', 'gender', 'role', 'login_at', 'login_ip', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'access_token', 'email', 'phone', 'nickname', 'city', 'province', 'country', 'language', 'avatar', 'create_by', 'update_by'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
    }

    public function isRemovable()
    {
        //return !in_array( Yii::$app->user->id,Yii::$app->params['super_member']) && $this->id !== Yii::$app->user->id;
        return false;
    }

    public function remove()
    {
        $this->role = User::ROLE_USER;
        return $this->save();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

}
