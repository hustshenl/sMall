<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\store\CertificationItem */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="certification-form">

    <?php $form = ActiveForm::begin();

    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [

            'name' => ['options' => ['placeholder' => '项目名称']],
            'label' => ['options' => ['placeholder' => '项目名称']],
            'status' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\SwitchInput',
                'options' => [
                    'containerOptions' => ['class' => ''],
                    'pluginOptions' => [
                        //'handleWidth'=>'90',
                        //'labelWidth'=>'90',
                        'onText' => '启用',
                        'offText' => '禁用',
                    ],
                ]
            ],
            'required' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\SwitchInput',
                'options' => [
                    'containerOptions' => ['class' => ''],
                    'pluginOptions' => [
                        'onText' => '必填',
                        'offText' => '选填',
                    ],
                ]
            ],
            'type' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => $model::$types,
                    'options' => ['placeholder' => '分类'],
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

            'items' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '认证描述']],
            'notice' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '认证描述']],
            //'content' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '认证内容']],
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div>' .
                    Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) . ' ' .
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                    '</div>'
            ],
        ]
    ]);

    ?>

    <?php ActiveForm::end(); ?>

</div>
