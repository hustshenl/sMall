<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Forget Password ?';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
<div class="site-request-password-reset">
    <h3><?= Html::encode($this->title) ?></h3>

    <p>Enter your e-mail address below to reset your password.</p>
    <?= $form->field($model, 'email') ?>
    <div class="form-actions">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
    </div>


</div>

<?php ActiveForm::end(); ?>
