<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '忘记密码？';

?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>s</b>Mall</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="row">
            <div class="col-xs-12">
                <p>Admin请到系统管理后台重置密码。</p>
                <p>其他管理员请到会员中心重置密码，或者联系Admin协助重置密码。</p>
            </div>
            <!-- /.col -->
            <div class="col-xs-12 text-right">
                <?= Html::a('返回登陆',['account/login'], ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
        </div>


    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
