<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel member\models\comic\Author */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('member', 'Authors');
$this->params['subTitle'] = $this->title ;
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    $this->params['subTitle']
];

$this->registerJs('SinMH.handleSearchForm("#btn-search",".author-search");');


?>



<div class="row author-index">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i><span
                        class="caption-subject bold uppercase"><?= $this->params['subTitle'] ?></span>
                </div>
                <div class="actions">
                    <?= Html::button(Yii::t('member', '显示/隐藏筛选栏'), ['class' => 'btn btn-primary btn-search', 'id' => 'btn-search']); ?>
                    &nbsp;
                    <?= Html::a(Yii::t('member', 'Create Author'), ['create'], ['class' => 'btn btn-success']); ?>
                </div>

            </div>
            <div class="portlet-body form">

                <!--搜索-->
                <!--<div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info">第<b>1-1</b>条，共<b>2</b>条数据.</div></div></div>-->
                <div class="table-container">
                    <?php
                    echo $this->render('_search', ['model' => $searchModel]);
                    //\yii\widgets\Pjax::begin();
                    echo GridView::widget([
                        'export'=>false,
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'dataTables_wrapper no-footer'],
                        'resizableColumns' => false,
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
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute'=>'slug',
                                'value' => 'slug',
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
                            'keywords',
                            'description',
                            [
                                'class' => 'hustshenl\metronic\widgets\ActionColumn',
                                'header' => Yii::t("member", '操作'),
                                'template' => "{:view} &nbsp; {:update} &nbsp; {:image} &nbsp; {:delete}",
                                'buttons' => [
                                    /*'delete' => function ($url, $model, $key) {
                                        return Html::a('<span class="icon-trash"></span>', $url, [
                                            'title' => \Yii::t('yii', 'Delete'),
                                            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '1',
                                            'class' => 'action-delete',
                                        ]);
                                    },*/
                                    'image' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-image"></i>', Url::to(['author/image','id'=>$key]), [
                                            'title' => \Yii::t('common', 'Image'),
                                        ]);
                                    },
                                ],
                                'headerOptions' => ['width' => '120px', 'style' => 'text-align: center;'],
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

