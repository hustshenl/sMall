<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\system\ModelAttribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="model-attribute-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'model_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'label') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'data_type') ?>

    <?php // echo $form->field($model, 'input_type') ?>

    <?php // echo $form->field($model, 'default_value') ?>

    <?php // echo $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'is_key') ?>

    <?php // echo $form->field($model, 'required') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
