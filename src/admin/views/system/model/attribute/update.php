<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\system\ModelAttribute */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'Model Attribute',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Model Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="model-attribute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
