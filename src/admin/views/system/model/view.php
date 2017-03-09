<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\system\Model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('content-header-actions');
echo common\widgets\Modal::widget([
    'id' => 'create-modal',
    'toggleButton' => [
        'label' => '新增字段',
        'class' => 'btn btn-success',
        'data-target' => '#create-modal',
        'href' => \yii\helpers\Url::toRoute(['attribute-create','id'=>$model->id,'mode'=>'modal']),
    ],
    'clientOptions' => false,
]);
$this->endBlock();
$isModal = Yii::$app->request->get('mode', '') == 'modal' && Yii::$app->request->isAjax;
?>
<?= $isModal ?
    \common\widgets\Modal::renderViewHeader($this->title) .
    Html::beginTag('div', ['class' => 'modal-body']) :
    Html::beginTag('div', ['class' => 'model-view']);
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
                    'attribute' => 'identifier',
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
                    'attribute' => 'type',
                    'format' => 'raw',
                    'value' => $model->type == \common\models\system\Model::TYPE_MODEL ?
                        '<span class="label label-info">模型</span>'
                        : '<span class="label label-info">表单</span>',
                    'valueColOptions' => ['style' => 'width:30%'],
                    'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                    'displayOnly' => true
                ],
            ],
        ],
        [
            'columns' => [
                [
                    'attribute' => 'table',
                    'valueColOptions' => ['style' => 'width:30%'],
                    'displayOnly' => true
                ],
                [
                    'attribute' => 'sort',
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
        'description',

    ],
]) ?>

<?php Pjax::begin(['id'=>'pjax-content']); ?>
<?= GridView::widget([
    'export' => false,
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'common\widgets\ActionColumn',
            'template' => '{view:attribute-view} {update:attribute-update} {delete:attribute-delete}'
        ],

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
        // 'extra',
        // 'description',
        // 'created_at',
        // 'updated_at',

    ],
]); ?>
<?php Pjax::end(); ?>
<?= Html::endTag('div'); ?>

