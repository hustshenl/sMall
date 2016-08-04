<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel member\models\base\CateGory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('member', 'Chapter Categories');
$this->params['subTitle'] = $this->title ;
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    $this->params['subTitle']
];
?>

<div class="row category-index">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i><span
                        class="caption-subject bold uppercase"><?= $this->params['subTitle'] ?></span>
                </div>
                <div class="actions">
                    <?= Html::a(Yii::t('member', '新增章节分类'), ['category-create'], ['class' => 'btn btn-success']); ?>
                </div>

            </div>
            <div class="portlet-body form">

                <!--搜索-->
                <!--<div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info">第<b>1-1</b>条，共<b>2</b>条数据.</div></div></div>-->
                <div class="table-container">
                    <?php
                    //echo $this->render('_search', ['model' => $searchModel]);
                    //\yii\widgets\Pjax::begin();
                    echo GridView::widget([
                        'export'=>false,
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'dataTables_wrapper no-footer'],
                        'resizableColumns' => true,
                        //'floatHeader' => true,
                        //'filterModel' => $searchModel,
                        'columns' => [
                            //['class' => 'hustshenl\metronic\widgets\CheckboxColumn','rowSelectedClass'=>'success selected'],
                            'id',
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute'=>'name',
                                'value' => 'name',
                                /*'readonly'=>function($model, $key, $index, $widget) {
                                    return (!$model->status); // do not allow editing of inactive records
                                },*/
                                'editableOptions' => [
                                    //'header' => '测试',
                                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                    'options' => [
                                        //'pluginOptions' => ['min'=>0, 'max'=>5000]
                                    ]
                                ],
                                'hAlign'=>'left',
                                'vAlign'=>'middle',
                                'format'=>'raw',
                                //'pageSummary' => true
                            ],
                            //'keywords',
                            //'description',
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute'=>'sort',
                                'value' => 'sort',
                                /*'readonly'=>function($model, $key, $index, $widget) {
                                    return (!$model->status); // do not allow editing of inactive records
                                },*/
                                'editableOptions' => [
                                    //'header' => '测试',
                                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                    'options' => [
                                        //'pluginOptions' => ['min'=>0, 'max'=>5000]
                                    ]
                                ],
                                'hAlign'=>'left',
                                'vAlign'=>'middle',
                                'format'=>'raw',
                                //'pageSummary' => true
                            ],
                            [
                                'class' => 'hustshenl\metronic\widgets\ActionColumn',
                                'header' => Yii::t("member", '操作'),
                                'template' => "{:delete}",
                                'buttons' => [
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<span class="icon-trash"></span>', '/chapter/category-delete?id='.$key, [
                                            'title' => \Yii::t('yii', 'Delete'),
                                            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                            'data-action' => 'delete',
                                            'class' => 'action-delete',
                                        ]);
                                    },
                                ],
                                'headerOptions' => ['style' => 'text-align: center;'],
                                'contentOptions' => ['align' => 'center']
                            ],
                        ],
                    ]);

                    //\yii\widgets\Pjax::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

