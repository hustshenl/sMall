<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \member\models\forms\LoginForm */

$this->title = Yii::t('member', 'Register Success');
$this->params['breadcrumbs'][] = $this->title;
//注册控制JS

?>



<div class="site-request-password-reset">
    <h3><?= Html::encode($this->title) ?></h3>

    <p><?= Yii::t('member', 'Please login with new account.') ?></p>

    <p class="clearfix text-center"><?= Html::a(Yii::t('member', 'Login'), ['account/login'], ['class' => 'btn btn-success',] ) ?></p>

</div>