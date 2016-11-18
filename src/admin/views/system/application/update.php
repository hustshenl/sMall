<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\system\Application */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'Application',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="application-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
