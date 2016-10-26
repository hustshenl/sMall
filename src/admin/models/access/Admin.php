<?php

namespace admin\models\access;

use mdm\admin\models\AuthItem;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\access\User as User;
use yii\rbac\Permission;

/**
 * User represents the model behind the search form about `common\models\access\User`.
 */
class Admin extends User
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
            [['id', 'status', 'scores', 'grade', 'gender', 'role', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'access_token', 'email', 'phone', 'nickname', 'city', 'province', 'country', 'language', 'avatar'], 'safe'],
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
        return !in_array( $this->id,Yii::$app->params['super_admin']) && $this->id !== Yii::$app->user->id;
    }

    public function remove()
    {
        $this->role = Admin::ROLE_USER;
        return $this->save();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE,'role'=>static::ROLE_ADMIN]);
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE,'role'=>static::ROLE_ADMIN]);
    }

    public function getPermission()
    {
        $manager = Yii::$app->getAuthManager();
        return $manager->getAssignments($this->id);
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->where(['type'=>1])
            ->viaTable('{{%auth_assignment}}', ['user_id' => 'id']);
        return 'aa';
    }

}
