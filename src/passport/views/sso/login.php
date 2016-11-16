<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\access\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(';login.init();');
?>
<div class="login-wrap" style="background-color: #e93854;">
    <div class="form form-group-lg">
        <h3 class="margin-bottom">用户登陆</h3>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientScript' => false]); ?>
        <div class="input-group margin-bottom"><!-- has-error-->
            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
            <input class="form-control" type="text" placeholder="用户名/邮箱/手机" name="username" autofocus>
        </div>
        <p class="help-block"></p>
        <div class="input-group margin-bottom">
            <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
            <input class="form-control" type="password" placeholder="密码" name="password">
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="checkbox">
                    <label for="remember-me">
                        <input type="hidden" name="rememberMe" value="0">
                        <input type="checkbox" id="remember-me" name="rememberMe" value="1" checked="">
                        自动登陆
                    </label>
                </div>
            </div>
            <div class="col-xs-6 text-right">
                <?= Html::a('忘记密码？', ['passport/request-password-reset']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('登 &nbsp; 陆', ['class' => 'btn btn-danger btn-lg btn-block', 'name' => 'login-button']) ?>
        </div>

        <div class="row">
            <div class="col-xs-8"></div>
            <div class="col-xs-4 text-right">
                <div style="color:#999;margin: 0">
                    <i class="fa fa-hand-o-right"></i><?= Html::a('立即注册', ['passport/register']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
