<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \passport\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(';register.init()');

?>
<div class="passport-register">

    <div class="row">
        <div class="col-xs-1"></div>
        <div class="col-xs-6">
            <!--<i class="icon-font">&#xe601;</i>
            <i class="icon-font">&#xe602;</i>
            <i class="icon-font">&#xe603;</i>
            <i class="icon-font">&#xe604;</i>
            <i class="icon-font">&#xe605;</i>
            <i class="icon-font">&#xe606;</i>
            <i class="icon-font">&#xe607;</i>
            <i class="icon-font">&#xe608;</i>
            <i class="icon-font">&#xe609;</i>
            <i class="icon-font">&#xe610;</i>
            <i class="icon-font">&#xe611;</i>
            <i class="icon-font">&#xe612;</i>
            <i class="icon-font">&#xe613;</i>
            <i class="icon-font">&#xe614;</i>
            <i class="icon-font">&#xe615;</i>
            <i class="icon-font">&#xe617;</i>
            <i class="icon-font">&#xe618;</i>
            <i class="icon-font">&#xe619;</i>
            <i class="icon-font">&#xe620;</i>
            <i class="icon-font">&#xe621;</i>
            <i class="icon-font">&#xe622;</i>
            <i class="icon-font">&#xe623;</i>
            <i class="icon-font">&#xe624;</i>
            <i class="icon-font">&#xe625;</i>
            <i class="icon-font">&#xe626;</i>
            <i class="icon-font">&#xe627;</i>
            <i class="icon-font">&#xe628;</i>-->
            <?php $form = ActiveForm::begin(['id' => 'register-form', 'enableClientScript' => false]); ?>
            <div class="form-group margin-bottom">
                <div class="input-group "><!-- has-error-->
                    <span class="input-group-addon">用户名</span>
                    <input class="form-control" title="用户名" type="text" placeholder="您的账户名和登录名"
                           name="username" maxlength="20" id="username" autofocus required
                           data-hint="<i class='fa fa-info-circle'></i> 支持中文、字母、数字、“-”“_”的组合，4-20个字符"/>
                    <i class="fa fa-check-circle"></i>
                    <i class="fa fa-spinner fa-pulse"></i>
                </div>
                <p class="help-block"><i class='fa fa-info-circle'></i> 支持中文、字母、数字、“-”“_”的组合，4-20个字符</p>
            </div>
            <div class="form-group margin-bottom">
                <div class="input-group "><!-- has-error-->
                    <span class="input-group-addon">设置密码</span>
                    <input class="form-control" type="password" placeholder="建议至少使用两种字符组合"
                           name="password" maxlength="20" id="password" required
                           data-hint="<i class='fa fa-info-circle'></i> 建议使用字母、数字和符号两种及以上的组合，6-20个字符"/>
                    <i class="fa fa-check-circle"></i>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="form-group margin-bottom">
                <div class="input-group "><!-- has-error-->
                    <span class="input-group-addon">确认密码</span>
                    <input class="form-control" type="password" placeholder="请再次输入密码" name="password2"
                           maxlength="20" id="password2"
                           data-hint="<i class='fa fa-info-circle'></i> 请再次输入密码"/>
                    <i class="fa fa-check-circle"></i>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="form-group margin-bottom">
                <div class="input-group "><!-- has-error-->
                    <span class="input-group-addon">手机号码</span>
                    <input class="form-control" type="tel" placeholder="建议使用常用手机" name="phone" id="phone"
                           required maxlength="11"
                           data-hint="<i class='fa fa-info-circle'></i> 完成验证后，可以使用该手机登录和找回密码"/>
                    <i class="fa fa-check-circle"></i>
                    <i class="fa fa-spinner fa-pulse"></i>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="form-group margin-bottom">
                <div class="input-group "><!-- has-error-->
                    <span class="input-group-addon">验证码</span>
                    <input class="form-control" type="text" placeholder="请输入验证码" name="captcha" id="captcha"
                           data-hint="<i class='fa fa-info-circle'></i> 看不清？点击图片更换验证码"/>
                    <?= Captcha::widget([
                        'name' => 'captcha',
                        'id' => 'captcha',
                        'template' => '<div class="verify-image">{image}</div>',
                    ]) ?>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="form-group margin-bottom">
                <div class="input-group "><!-- has-error-->
                    <span class="input-group-addon">手机验证码</span>
                    <input class="form-control" type="number" placeholder="请输入手机验证码" name="verification_code"
                           id="verification_code" required/>
                    <div class="get-verification-code" id="get-verification-code">获取手机验证码</div>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="form-group margin-bottom">
                <div class="checkbox">
                    <label for="agree" style="color: #333;">
                        <input type="checkbox" id="agree" name="agree" value="1" checked />
                        我已阅读并同意 <a href="#">《用户注册协议》</a>
                    </label>
                </div>
                <p class="help-block"></p>
            </div>

            <div class="form-group">
                <?= Html::submitButton('立即注册', ['class' => 'btn btn-danger btn-lg btn-block', 'name' => 'register-button','id'=>'register-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-xs-1"></div>
        <div class="col-xs-4">提示信息</div>
    </div>
</div>
