<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = '邮件发送成功';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-request-password-reset">
    <h3><?= Html::encode($this->title) ?></h3>

    <p>请检查邮件，并按照邮件指引进行操作。</p>

    <p><?= Html::a('返回主页', Url::home(), ['class' => 'btn btn-success pull-right',] ) ?></p>
<!--    <div class="form-actions">
        <?/*= Html::button('Close', ['class' => 'btn btn-success pull-right', 'onclick' => 'window.open(\'about:blank\',\'_self\');window.close();',] ) */?>
    </div>-->


</div>
