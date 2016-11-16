<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\access\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helpers\SMall;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(SMall::getResourceHost().'/css/sso.css');
$this->registerJs(';sso.initSsoForm();');
?>

<link rel="stylesheet" href="<?=SMall::getResourceHost().'/css/sso.css' ?>">
<div class="sso-wrap">
    <div class="form">
        <h3 style="padding: 20px 0 0;margin: 0;">用户登陆</h3>
        <?php $form = ActiveForm::begin(['id' => 'sso-form', 'enableClientScript' => false]); ?>
        <div id="sso-message"
             style="display:none;"
             class="sso-message error">
            <i class="icon-font">&#xe604;</i>
            <p class="sso-error" id="sso-error"></p>

        </div>

        <div class="sso-input-group margin-bottom"><!-- has-error-->
            <span class="sso-input-group-addon"><i class="icon-font">&#xe601;</i></span>
            <input class="sso-form-control" type="text" placeholder="用户名/邮箱/手机" name="username" autofocus>
        </div>
        <p class="help-block"></p>
        <div class="sso-input-group margin-bottom">
            <span class="sso-input-group-addon"><i class="icon-font">&#xe600;</i></span>
            <input class="sso-form-control" type="password" placeholder="密码" name="password">
        </div>
        <div class="sso-row" style="height: 32px;">
            <div style="float: left">
                <div class="sso-checkbox">
                    <label for="remember-me" style="font-weight: normal;vertical-align: middle;margin: 0;">
                        <input type="hidden" name="rememberMe" value="0">
                        <input type="checkbox" id="remember-me" name="rememberMe" value="1" checked="" style="margin: 0;vertical-align: middle;">
                        自动登陆
                    </label>
                </div>
            </div>
            <div style="float: right;text-align: right;">
                <?= Html::a('忘记密码？', ['passport/request-password-reset']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('登 &nbsp; 陆', ['class' => 'sso-btn sso-btn-danger', 'name' => 'login-button','id'=>'login-button']) ?>
        </div>

        <div class="oss-row" style="height: 32px;">
            <div style="float: left;"></div>
            <div style="float: right;text-align: right;">
                <div style="color:#999;margin: 0">
                    <?= Html::a('立即注册', ['passport/register']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script src="<?=SMall::getPassportHost();?>/javascript/config"></script>
<script src="<?=SMall::getResourceHost();?>/js/lib/jsencrypt.js"></script>
<script src="<?=SMall::getResourceHost();?>/js/lib/security.js"></script>
<script type="text/javascript">jQuery(document).ready(function () {sso.initSsoForm();});</script>
