<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model common\models\user\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin();
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            /*'category' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['authorCategory'],
                    'options' => ['placeholder' => '分类'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'status' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => [0=>'禁用',10=>'正常'],
                    'options' => ['placeholder' => '状态'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],

            'vip' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['vipStatus'],
                    'options' => ['placeholder' => '是否VIP'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],*/
            'username' => ['options' => ['placeholder' => '搜索名称']],
            'email' => ['options' => ['placeholder' => '搜索Email']],
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div>' .
                    Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']). ' ' .
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                    '</div>'
            ],
        ]
    ]);

    ?>



    <?php ActiveForm::end(); ?>

</div>
