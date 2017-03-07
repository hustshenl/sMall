<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\system\Application;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\system\Application */
/* @var $dataProvider yii\data\ActiveDataProvider */
\kartik\detail\DetailViewAsset::register($this);
$this->title = Yii::t('admin', 'Applications');
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('content-header-actions');

echo \common\widgets\Modal::widget([
    'id' => 'create-modal',
    'toggleButton' => [
        'label' => 'Create Application',
        'class' => 'btn btn-success',
        'data-target' => '#create-modal',
        'href' => \yii\helpers\Url::toRoute(['create','mode'=>'modal']),
    ],
    'clientOptions' => false,
]);
//echo Html::a(Yii::t('admin', 'Create Application'), ['create'], ['class' => 'btn btn-success']);
//echo ' '.Html::button(Yii::t('common', '多选'), ['class' => 'btn btn-info multi-select']);
//echo ' '.Html::button(Yii::t('common', '高级筛选'), ['class' => 'btn btn-info advance-search-trigger']);
$this->endBlock();
$this->registerJs(<<<JS
//yii.actionColumn.onLoad = {};
JS
);
?>
<div class="application-index">

    <?php $editableUrl = \yii\helpers\Url::to(['ajax-update', 'editable' => 1]); ?>
    <?php Pjax::begin(['id'=>'pjax-content']); ?>

    <?= GridView::widget([
        'export'=>false,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{view} {update} {delete}'
            ],
            'id',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'name',
                'value' => 'name',
                /*'readonly'=>function($model, $key, $index, $widget) {
                    return (!$model->status); // do not allow editing of inactive records
                },*/
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'pjaxContainerId' => 'pjax-content',
                    'formOptions' => ['action' => $editableUrl]
                ],

                'hAlign' => 'left',
                'vAlign' => 'middle',
                //'width' => '100px',
                'format' => 'raw',
                //'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'identifier',
                'value' => 'identifier',

                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'pjaxContainerId' => 'pjax-content',
                    'formOptions' => ['action' => $editableUrl]
                ],

                'hAlign' => 'left',
                'vAlign' => 'middle',
                //'width' => '100px',
                'format' => 'raw',
                //'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'host',
                'value' => 'host',
                /*'readonly'=>function($model, $key, $index, $widget) {
                    return (!$model->status); // do not allow editing of inactive records
                },*/
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'pjaxContainerId' => 'pjax-content',
                    'formOptions' => ['action' => $editableUrl]
                ],

                'hAlign' => 'left',
                'vAlign' => 'middle',
                //'width' => '100px',
                'format' => 'raw',
                //'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'ip',
                'value' => 'ip',
                /*'readonly'=>function($model, $key, $index, $widget) {
                    return (!$model->status); // do not allow editing of inactive records
                },*/
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'pjaxContainerId' => 'pjax-content',
                    'formOptions' => ['action' => $editableUrl]
                ],

                'hAlign' => 'left',
                'vAlign' => 'middle',
                //'width' => '100px',
                'format' => 'raw',
                //'pageSummary' => true
            ],

            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status',
                'value' => 'status',
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'pjaxContainerId' => 'pjax-content',
                    'data' => Yii::$app->params['lookup']['status'],
                    'formOptions' => ['action' => $editableUrl]
                ],
                'hAlign' => 'center',
                'vAlign' => 'middle',
                //'width' => '100px',
                'format' => ['lookup', 'status'],
            ],
            [
                'attribute'=>'type',
                'value'=>function($model){
                    return Application::$types[$model->type];
                }
            ],
            'description',
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
