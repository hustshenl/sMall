<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\member\Subscribe */

$this->title = Yii::t('common', 'Update {modelClass}: ', [
    'modelClass' => 'Subscribe',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Subscribes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="subscribe-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
