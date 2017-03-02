<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\store\Certification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certification-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'icon') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'deposit') ?>

    <?php // echo $form->field($model, 'expires_in') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'reference') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
