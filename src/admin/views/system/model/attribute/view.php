<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\system\ModelAttribute */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Model Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-attribute-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('admin', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('admin', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('admin', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'model_id',
            'status',
            'name',
            'label',
            'sort',
            'data_type',
            'input_type',
            'default_value',
            'length',
            'is_key',
            'required',
            'extra',
            'description',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
