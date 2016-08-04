<?php
use yii\helpers\Html;
use hustshenl\metronic\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\access\LoginForm */

$this->title = 'Sign In';
$this->params['breadcrumbs'][] = $this->title;
//注册控制JS
$this->registerJs('Metronic.init();
	Layout.init();
	Login.init();
	Demo.init();
');
?>


    <?php $form = ActiveForm::begin(['id' => 'login-form',
        'options' => ['class'  =>  'login-form',],
    ]); ?>
    <h3 class="form-title"><?= Html::encode($this->title) ?></h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
    </div>
    <?=  $form->field($model, 'username')  ?>
    <?=  $form->field($model, 'password')->passwordInput()  ?>
    <?=  $form->field($model, 'rememberMe')->checkbox() ?>
    <div class="form-actions">
        <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
        <a href="javascript:;"  id="forget-password" class="forget-password">Forgot Password?</a>
    </div>
    <div class="create-account"style="display: none;">
        <p>
            <a href="<?= Url::toRoute('account/signup') ?>" class="uppercase">Create an account</a>
        </p>
    </div>

    <?php ActiveForm::end(); ?>


<?php $form = ActiveForm::begin(['id' => 'forget-form',
    'options' => ['class'  =>  'forget-form',],
    'action'=>['account/request-password-reset'],
]); ?>
<input type="hidden" name="_csrf" value="<?= \Yii::$app->request->getCsrfToken() ?>">
<h3>忘记密码了 ?</h3>

<p>
    在下面输入您的Email即可找回密码：
</p>

<div class="form-group">
    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="PasswordResetRequestForm[email]"/>
</div>
<div class="form-actions">
    <button type="button" id="back-btn" class="btn btn-default">返回</button>
    <button type="submit" class="btn btn-success uppercase pull-right">提交</button>
</div>

<?php ActiveForm::end(); ?>



<!-- BEGIN FORGOT PASSWORD FORM
<form class="forget-form" action="/account/request-password-reset"
      method="post">
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->getCsrfToken() ?>">
    <h3>Forget Password ?</h3>

    <p>
        Enter your e-mail address below to reset your password.
    </p>

    <div class="form-group">
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="PasswordResetRequestForm[email]"/>
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn btn-default">Back</button>
        <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
</form>
<!-- END FORGOT PASSWORD FORM -->
<!-- BEGIN REGISTRATION FORM -->
<form class="register-form" action="/account/signup"
      method="post">
    <h3>Sign Up</h3>

    <p class="hint">
        Enter your personal details below:
    </p>

    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Full Name</label>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="fullname"/>
    </div>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email"/>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Address</label>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address"/>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">City/Town</label>
        <input class="form-control placeholder-no-fix" type="text" placeholder="City/Town" name="city"/>
    </div>
    <p class="hint">
        Enter your account details below:
    </p>

    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username"
               name="username"/>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password"
               placeholder="Password" name="password"/>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
               placeholder="Re-type Your Password" name="rpassword"/>
    </div>
    <div class="form-group margin-top-20 margin-bottom-20">
        <label class="check">
            <input type="checkbox" name="tnc"/> I agree to the <a href="#">
                Terms of Service </a>
            & <a href="#">
                Privacy Policy </a>
        </label>

        <div id="register_tnc_error">
        </div>
    </div>
    <div class="form-actions">
        <button type="button" id="register-back-btn" class="btn btn-default">Back</button>
        <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
</form>
<!-- END REGISTRATION FORM -->


