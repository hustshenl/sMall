<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use common\components\Upload;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="portlet-body form-body admin-form">
    <!-- BEGIN FORM-->
    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'username' => ['options' => ['placeholder' => '用户名', 'disabled' => true]],
            'email' => ['options' => ['placeholder' => '输入Email']],
            'password' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => '输入密码']],
            'nickname' => ['options' => ['placeholder' => '输入昵称']],
            'phone' => ['options' => ['placeholder' => '输入电话号码']],
            'remark' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '输入备注信息']],
        ]
    ]);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div style="text-align: center; margin-top: 20px">' .
                    Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'),['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']). ' &nbsp; ' .
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                    '</div>'
            ],
        ]
    ]);

    ActiveForm::end(); ?>
    <!-- END FORM-->
</div>
<?php
?>
