<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel admin\models\store\Certification */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Certifications');
$this->params['breadcrumbs'][] = $this->title;
$this->blocks['hideTitle'] = false;
$this->registerJs(<<<JS
yii.actionColumn.onLoad = {};
JS
);


$this->beginBlock('content-header-actions');
echo Html::a(Yii::t('admin', 'Create Certification'), ['create'], ['class' => 'btn btn-success']);
//echo ' '.Html::button(Yii::t('common', '多选'), ['class' => 'btn btn-info multi-select']);
//echo ' '.Html::button(Yii::t('common', '高级筛选'), ['class' => 'btn btn-info advance-search-trigger']);
$this->endBlock();
?>
<div class="certification-index">

    <?= GridView::widget([
        'export' => false,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{view::bottom} {update} {delete}'
            ],
            'id',
            'status',
            'type',
            'name',
            'description',
            // 'icon',
            // 'price',
            // 'deposit',
            // 'expires_in',
            // 'content:ntext',
            // 'sort',
            // 'reference',
            // 'created_at',
            // 'updated_at',

        ],
    ]); ?>
</div>
