<?php
namespace member\models\forms;

use common\models\access\Auth;
use common\models\access\User;
use yii\base\Model;
use yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['password2'], 'compare', 'compareAttribute' => 'password'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $authId = Yii::$app->session->get('auth_id',false);
                if($authId){
                    /**
                     * @var Auth $auth
                     */
                    $auth = Auth::findOne($authId);
                    $auth->user_id = $user->id;
                    if ($auth->save()) {
                        Yii::$app->session->remove('auth_id');
                    }
                }
                return $user;
            }
        }

        return false;
    }
}
