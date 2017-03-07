<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\system\ModelAttribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="model-attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'data_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'input_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'default_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'length')->textInput() ?>

    <?= $form->field($model, 'is_key')->textInput() ?>

    <?= $form->field($model, 'required')->textInput() ?>

    <?= $form->field($model, 'extra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
