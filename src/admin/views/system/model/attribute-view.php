<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\system\ModelAttribute */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Model Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isModal = Yii::$app->request->get('mode', '') == 'modal' && Yii::$app->request->isAjax;
?>
<?= $isModal ?
    \common\widgets\Modal::renderViewHeader($this->title) .
    Html::beginTag('div', ['class' => 'modal-body']) :
    Html::beginTag('div', ['class' => 'attribute-view']);
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'columns' => [
                    [
                        'attribute' => 'name',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'displayOnly' => true
                    ],
                    [
                        'attribute' => 'label',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly' => true
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => $model->status ?
                            '<span class="label label-success">启用</span>'
                            : '<span class="label label-danger">禁用</span>',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'displayOnly' => true
                    ],
                    [
                        'attribute' => 'sort',
                        'format' => 'raw',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly' => true
                    ],
                ],
            ],

            [
                'columns' => [
                    [
                        'attribute' => 'data_type',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'displayOnly' => true
                    ],
                    [
                        'attribute' => 'input_type',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly' => true
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'default_value',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'displayOnly' => true
                    ],
                    [
                        'attribute' => 'length',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly' => true
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'is_key',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'displayOnly' => true
                    ],
                    [
                        'attribute' => 'required',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly' => true
                    ],
                ],
            ],

            [
                'columns' => [
                    [
                        'attribute' => 'created_at',
                        'format' => 'date',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'displayOnly' => true
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => 'datetime',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly' => true
                    ],
                ],
            ],
            'extra',
            'description',
        ],
    ]) ?>
<?= Html::endTag('div'); ?>
