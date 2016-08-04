<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('member', 'Email Send Success.');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-request-password-reset">
    <h3><?= Html::encode($this->title) ?></h3>

    <p><?=Yii::t('member', 'Please check the mail and operate according to the guidelines of the mail.');?></p>

    <p class="clearfix"><?= Html::a(Yii::t('common', 'OK'), Url::home(), ['class' => 'btn btn-success pull-right',] ) ?></p>



</div>
