<?php

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Author */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="author-form">

    <?php
    $form = ActiveForm::begin([
        //'options' => ['enctype' => 'multipart/form-data'],
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]);

    $userListUrl = \yii\helpers\Url::to(['member/index']);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'name' => ['options' => ['placeholder' => '作者笔名，审核通过即不可修改']],
        ]
    ]);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '认证信息，审核通过即不可修改！', 'rows' => 4]],
        ]
    ]);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div style="text-align: center; margin-top: 20px">' .
                    Button::widget(
                        ['label' => $model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]
                    ) .
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                    '</div>'
            ],
        ]
    ]);
    ?>

    <!--<div class="form-group text-center">
    </div>-->
    <?php ActiveForm::end(); ?>

</div>
