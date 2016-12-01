<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \passport\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '恭喜，注册成功！';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(';register.init()');
/** @var \common\models\access\User $user */
$user = Yii::$app->user->identity;

?>
<div class="passport-register-success">
    <div class="jumbotron">
        <h1>恭喜，注册成功！</h1>
        <p class="lead">请牢记您的用户名“<?= $user->username;?>”，请妥善保管<br />如果您忘记密码，可以使用您的手机号“<?= $user->phone;?>”找回密码<br />马上开始购物之旅吧。</p>

        <p><a class="btn btn-lg btn-success" href="<?= \common\helpers\SMall::getHost('app-main')?>">回到首页</a></p>
    </div>

</div>
