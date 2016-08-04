<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model member\models\comic\Chapter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chapter-search hide">
    <?php
    $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showErrors' => true,
            'showLabels' => false,
        ],
        'action' => ['index','comic_id'=>$model->comic_id],
        'method' => 'get',
    ]);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 6,
        //'columnOptions'=>['colspan'=>2],
        'attributes' => [
            //'comic_id'=>['type'=>Form::INPUT_HIDDEN],
            'status' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['approveStatus'],
                    'options' => ['placeholder' => '审核状态'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'is_vip' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['vipStatus'],
                    'options' => ['placeholder' => 'VIP章节'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'category' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => $categories,
                    'options' => ['placeholder' => '章节类型'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'name' => ['options' => ['placeholder' => '章节名']],
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div>' .
                    Html::submitButton(Yii::t('member', 'Search'), ['class' => 'btn btn-primary']) .
                    /*Button::widget(
                        ['label' => $model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]
                    ) .*/
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                    '</div>'
            ],
        ]
    ]);
    ActiveForm::end();
    ?>

</div>
