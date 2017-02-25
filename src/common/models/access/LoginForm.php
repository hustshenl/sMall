<?php
namespace common\models\access;

use common\helpers\Security;
use yii;
use yii\base\Model;

/**
 * Login form
 * @package common\models\access
 *
 * @property string $accountType
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;
    private $_accountType = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
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
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function load($data, $formName = null)
    {
        if (!parent::load($data, $formName)) return false;
        $decrypted = Security::rsaDecrypt($this->password);
        preg_match('/^(?P<salt>\w{1,16})___(?P<password>.*)/i', $decrypted, $matches);
        if (empty($matches)) {
            $this->password = $decrypted;
        } else {
            $salt = Yii::$app->session->get('sso.salt');
            Yii::$app->session->remove('sso.salt');
            if ($salt != $matches['salt']) {
                $this->addError('password', '登陆超时，请刷新页面！');
                return false;
            }
            $this->password = $matches['password'];
        }
        return true;
    }


    public function success()
    {
        if ($this->accountType == 'master') {
            return ['data' => Yii::$app->user->identity];
        }
        //  TODO 获取子帐号跳转登录连接
        $redirect = '';
        return ['redirect' => $redirect];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        $user = $this->getUser();
        if ($this->validate()) {
            $user->generateAuthKey();
            $user->save();
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            if ($this->accountType == 'master') {
                $this->_user = User::findByUsername($this->username);
            } else {
                $this->_user = Seller::findByUsername($this->username);
            }
        }
        return $this->_user;
    }

    public function getAccountType()
    {
        if ($this->_accountType === false) {
            if (strpos($this->username, ':') === false) {
                $this->_accountType = 'master';
            } else {
                $this->_accountType = 'slave';
            }
        }
        return $this->_accountType;
    }
}
