<?php
namespace backend\models;

use common\models\access\User as Admin;
use yii\base\Model;
use yii;
use yii\web\Cookie;

/**
 * LoginForm
 */
class LoginForm extends Model
{
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (Yii::$app->params['access_token'] != md5($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }
    public function login()
    {
        if ($this->validate()) {
            Yii::$app->session->set('accessed',true);
            return true;
        } else {
            return false;
        }
    }
}
