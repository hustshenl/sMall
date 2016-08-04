<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model member\models\member\Subscribe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscribe-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'comic_id') ?>

    <?= $form->field($model, 'read_chapter') ?>

    <?php // echo $form->field($model, 'read_chapter_id') ?>

    <?php // echo $form->field($model, 'read_at') ?>

    <?php // echo $form->field($model, 'read_page') ?>

    <?php // echo $form->field($model, 'update_chapter') ?>

    <?php // echo $form->field($model, 'update_chapter_id') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
