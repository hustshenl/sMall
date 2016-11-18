<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\system\Application;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\system\Application */
/* @var $dataProvider yii\data\ActiveDataProvider */
\kartik\detail\DetailViewAsset::register($this);
$this->title = Yii::t('admin', 'Applications');
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('content-header-actions');
echo Html::a(Yii::t('admin', 'Create Application'), ['create'], ['class' => 'btn btn-success']);
//echo ' '.Html::button(Yii::t('common', '多选'), ['class' => 'btn btn-info multi-select']);
//echo ' '.Html::button(Yii::t('common', '高级筛选'), ['class' => 'btn btn-info advance-search-trigger']);
$this->endBlock();
$this->registerJs(<<<JS
yii.actionColumn.onLoad = {};
JS
);
?>
<div class="application-index">

    <?php $editableUrl = \yii\helpers\Url::to(['ajax-update', 'editable' => 1]); ?>
    <?= GridView::widget([
        'export'=>false,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{view::bottom} {update::_blank} {delete}'
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
                'attribute' => 'slug',
                'value' => 'slug',

                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
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
</div>
