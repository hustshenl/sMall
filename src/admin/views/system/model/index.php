<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\system\ModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Models');
$this->params['breadcrumbs'][] = $this->title;
$this->blocks['hideTitle'] = false;
$this->registerJs(<<<JS
yii.actionColumn.onLoad = {};
JS
);


$this->beginBlock('content-header-actions');

echo common\widgets\Modal::widget([
    'id' => 'create-modal',
    'toggleButton' => [
        'label' => 'Create Model',
        'class' => 'btn btn-success',
        'data-target' => '#create-modal',
        'href' => \yii\helpers\Url::toRoute(['create','mode'=>'modal']),
    ],
    'clientOptions' => false,
]);
//echo Html::a(Yii::t('admin', 'Create Model'), ['create'], ['class' => 'btn btn-success']);
$this->endBlock();
?>
<div class="model-index">

    <?php Pjax::begin(['id'=>'pjax-content']); ?>
    <?= GridView::widget([
        'export' => false,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{view} {update} {delete}'
            ],

            'id',
            'name',
            'status',
            'type',
            'table',
            'description',
            'sort',
            // 'created_at',
            // 'updated_at',

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
