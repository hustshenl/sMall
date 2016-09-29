<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\member\member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'nickname') ?>

    <?= $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'access_token') ?>

    <?php // echo $form->field($model, 'identity') ?>

    <?php // echo $form->field($model, 'identity_sn') ?>

    <?php // echo $form->field($model, 'qq') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'weibo') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'postcode') ?>

    <?php // echo $form->field($model, 'scores') ?>

    <?php // echo $form->field($model, 'grade') ?>

    <?php // echo $form->field($model, 'credit') ?>

    <?php // echo $form->field($model, 'vip') ?>

    <?php // echo $form->field($model, 'vip_scores') ?>

    <?php // echo $form->field($model, 'vip_expires') ?>

    <?php // echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <?php // echo $form->field($model, 'signature') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'register_ip') ?>

    <?php // echo $form->field($model, 'login_at') ?>

    <?php // echo $form->field($model, 'login_ip') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
