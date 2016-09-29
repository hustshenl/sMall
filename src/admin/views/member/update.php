<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\member\Member */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'Member',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="member-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="action-ajax-content">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
