<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = Yii::t('member', 'Forgot Password?');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
\yii\widgets\Pjax::begin();
$form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
<div class="site-request-password-reset">
    <h3><?= Html::encode($this->title) ?></h3>

    <p><?= Yii::t('member', 'Enter your e-mail address below to reset your password.') ?></p>
    <?= $form->field($model, 'email') ?>
    <div class="form-actions">
        <!--<button type="button" id="back-btn" class="btn default">返回登陆</button>-->
        <?= Html::a(Yii::t('member', 'Back to Login'), ['account/login'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton(Yii::t('common', 'Send'), ['class' => 'btn btn-success pull-right']) ?>
    </div>


</div>

<?php ActiveForm::end();
\yii\widgets\Pjax::end();
?>
