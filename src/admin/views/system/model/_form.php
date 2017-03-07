<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\system\Model */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="model-form">

    <!-- BEGIN FORM-->
    <?php
    $validationUrl = $model->isNewRecord?['validate']:['validate','id'=>$model->id];
    $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'enableAjaxValidation' => true,
        'validationUrl' => \yii\helpers\Url::toRoute($validationUrl),
        'formConfig' => ['deviceSize' => ActiveForm::SIZE_LARGE], // 垂直排列时不要设置 'labelSpan' => 2,
    ]);

    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'name' => ['options' => ['placeholder' => '请输入模型名称...']],
            'status' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\SwitchInput',
                'options' => [
                    'containerOptions' => ['class' => ''],
                    'pluginOptions' => [
                        'onText' => '启用',
                        'offText' => '禁用',
                    ],
                ]
            ],
            'identifier' => ['options' => ['placeholder' => '建议使用小写字母...']],
            'table' => ['options' => ['placeholder' => '建议使用小写字母...']],
            'type' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => \common\models\system\Model::$types,
                    'options' => ['placeholder' => '模型类型'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'sort' => [
                //'label'=>false,
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\TouchSpin',
                'options' => [
                    'pluginOptions' => [
                        'buttonup_class' => 'btn btn-primary',
                        'buttondown_class' => 'btn btn-info',
                        //'step' => 10,
                        'max' => 999999999,
                        'min' => -999999999
                    ],
                ]
            ],
        ]
    ]);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'description' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入应用描述...','rows'=>3]],
        ]
    ]);

    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div style="text-align: center; margin-top: 20px">' .
                    Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) . ' ' .
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) .
                    '</div>'
            ],
        ]
    ]);
    ActiveForm::end();
    ?>
    <!-- END FORM-->


</div>
