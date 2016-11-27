<?php
namespace passport\models;

use common\helpers\Security;
use yii;
use yii\base\Model;
use common\models\access\User;

/**
 * Register  form
 */
class RegisterForm extends Model
{
    public $username;
    public $phone;
    public $verification_code;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\access\User', 'message' => '该用户名已被使用，请重新输入'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['verification_code','string','min'=>4,'max'=>10],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function load($data, $formName = null)
    {
        if(!parent::load($data, $formName)) return false;

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
        $verification = Yii::$app->session->get('verification.phone');
        if($verification == null||!isset($verification['phone'],$verification['code'],$verification['send_at'])){
            $this->addError('verification_code','手机验证码验证失败，请先获取验证码');
            return false;
        }
        if(time()-15*60>$verification['send_at']){
            $this->addError('verification_code','验证超时，请在验证码发送15分钟内完成验证。');
            return false;
        }
        if(isset($verification['verifyCount'])&&$verification['verifyCount']>=3){
            $this->addError('verification_code','手机验证码错误次数超限，请重新获取');
            return false;
        }
        if($verification['code'] == $this->verification_code){
            $this->phone = $verification['phone'];
            Yii::$app->session->remove('verification.phone');
        }else{
            $verification['verifyCount'] = yii\helpers\ArrayHelper::getValue($verification,'verifyCount',0)+1;
            $this->addError('verification_code','手机验证码输入错误，请重新输入');
            Yii::$app->session->set('verification.phone',$verification);
            return false;
        }
        return true;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if (!$this->validate()) {
            return null;
        }
        // TODO 判断手机号是否注册，若已经注册，则接触绑定
        $phoneUser = User::findOne(['phone'=>$this->phone]);
        if(!empty($phoneUser)) $phoneUser->removePhone();
        $user = new User();
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
