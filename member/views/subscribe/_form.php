<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\member\Subscribe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscribe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'comic_id')->textInput() ?>

    <?= $form->field($model, 'read_chapter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'read_chapter_id')->textInput() ?>

    <?= $form->field($model, 'read_at')->textInput() ?>

    <?= $form->field($model, 'read_page')->textInput() ?>

    <?= $form->field($model, 'update_chapter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_chapter_id')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
