<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\user\User */

$this->title = Yii::t('seller', 'Update {modelClass}: ', [
        'modelClass' => 'User',
    ]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('seller', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('seller', 'Update');
?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
