<?php
namespace backend\models;

use common\models\access\User as Admin;
use yii\base\Model;
use yii;

/**
 * Signup form
 */
class AdminForm extends Model
{
    public $id;
    public $username;
    public $nickname;
    public $phone;
    public $remark;
    public $email;
    public $password;
    public $isNewRecord = true;

    /**
     * @param array $config
     * @param bool $item
     */
    public  function __construct($config = [],$item = false){

        parent::__construct($config);

        if($item){
            $this->attributes = $item;
            $this->isNewRecord = false;
        }
    }
    public function init()
    {
        parent::init();
        $this->username = 'Admin';
        // ... 配置生效后的初始化过程
    }
        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],
            //['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['nickname','phone'], 'string', 'max' => 50],
        ];
    }
    /**
     * 判断用户名称是否重复
     */
    public function unique($attribute){

        $query = Admin::find()->andWhere([$attribute=>trim($this->$attribute)]);
        if(!$this->isNewRecord) $query->andWhere(' id != :id',['id'=>$this->id]);
        $model = $query->one();
        if($model !== null){
            $message = Yii::t('admin', '"{value}" 已经存在.');
            $params = [
                'attribute' => $this->getAttributeLabel($attribute),
                'value' => $this->$attribute,
            ];
            $this->addError($attribute, Yii::$app->getI18n()->format($message, $params, Yii::$app->language));
        }
    }

    /**
     * Signs user up.
     *
     * @return Admin|null the saved model or null if saving fails
     */
    public function add()
    {
        if ($this->validate()) {
            $user = new Admin();
            $user->username = 'Admin';
            $user->email = $this->email;
            $user->role = Admin::ROLE_ADMIN;
            if(!empty($this->nickname)) $user->nickname = $this->nickname;
            if(!empty($this->phone)) $user->phone = $this->phone;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
    public function edit()
    {
        if ($this->validate()) {
            $user = Admin::findOne(['username'=>'Admin']);
            //$user->username = 'Admin';
            $user->email = $this->email;
            $user->role = Admin::ROLE_ADMIN;
            if(!empty($this->nickname)) $user->nickname = $this->nickname;
            if(!empty($this->phone)) $user->phone = $this->phone;
            if($this->password !== null){
                $user->setPassword($this->password);
                $user->generateAuthKey();
            }
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
