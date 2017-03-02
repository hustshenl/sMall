<?php
namespace seller\models\forms;

use common\models\access\User;
use yii\base\Model;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Signup form
 */
class Admin extends Model
{
    public $user_id;

    /**
     * @param array $config
     * @param bool $item
     */
    public  function __construct($config = [],$item = false){

        parent::__construct($config);

        if($item){
            $this->attributes = $item;
        }
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('common', '查找用户'),
        ];
    }

    public function signup()
    {
        $user = $this->findModel($this->user_id);
        $user->role = User::ROLE_ADMIN;
        $user->save();
        return $user;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findIdentity($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
