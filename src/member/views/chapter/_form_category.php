<?php

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\base\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php
    $form = ActiveForm::begin([
        //'options' => ['enctype' => 'multipart/form-data'],
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]);

    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'name' => ['options' => ['placeholder' => '分类名称']],
            'sort' => ['options' => ['placeholder' => '排序值']],
        ]
    ]);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'actions'=>[
                'type'=>Form::INPUT_RAW,
                'value'=>'<div style="text-align: center; margin-top: 20px">' .
                    Button::widget(
                        ['label' => $model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]
                    ) .' &nbsp; '.
                    Html::resetButton(Yii::t('common', 'Reset'), ['class'=>'btn btn-info']) . ' ' .
                    '</div>'
            ],
        ]
    ]);
    ?>

    <!--<div class="form-group text-center">
    </div>-->
    <?php ActiveForm::end(); ?>

</div>
