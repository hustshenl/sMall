<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use hustshenl\metronic\widgets\CheckboxColumn;
use hustshenl\metronic\widgets\Button;
use hustshenl\metronic\widgets\ButtonDropdown;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $comic common\models\comic\Comic */
/* @var $searchModel member\models\comic\Chapter */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories array */

$this->title = $comic->name.' / '.\Yii::t('member', 'Chapters');
$this->params['subTitle'] = $this->title;
/*$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    ['label' => $comic->name, 'url' => ['comic/view', 'id' => $comic->id]],
    $this->params['subTitle']
];*/

$this->registerJs('SinMH.handleSearchForm("#btn-search",".chapter-search");ChapterIndex.init();');
$this->registerJsFile("@web/js/chapter/index.js",['position'=>$this::POS_END,'depends'=>[\hustshenl\metronic\bundles\ThemeAsset::className()]]);

$cateItems=[];
foreach($categories as $key => $value){
    $item['label'] = $value;
    $item['url'] = "javascript:ChapterIndex.modifyCategory({$key});";
    $cateItems[] = $item;
}
?>


<div class="row chapter-index">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i><span
                        class="caption-subject bold uppercase"><?= $this->params['subTitle'] ?></span>
                </div>
                <div class="actions">
                    <?= Html::button(Yii::t('member', '显示/隐藏筛选栏'), ['class' => 'btn btn-info btn-search', 'id' => 'btn-search']); ?>
                    &nbsp;
                    <?= Html::a(Yii::t('member', '新增章节'), ['create','comic_id'=>$comic->id], ['class' => 'btn btn-success']); ?> &nbsp;
                    <?= ButtonDropdown::widget([
                        'label' => '修改分类',
                        'button' => [
                            //'icon' => 'fa fa-bookmark-o',
                            //'iconPosition' => Button::ICON_POSITION_LEFT,
                            //'size' => Button::SIZE_SMALL,
                            'disabled' => false,
                            'block' => false,
                            'type' => Button::TYPE_PRIMARY,
                            'color' => Button::TYPE_PRIMARY,
                        ],
                        'dropdown' => [
                            'options' => ['class' => 'pull-right'],
                            'items' => $cateItems,
                        ],
                    ]); ?>
                </div>

            </div>
            <div class="portlet-body form">

                <!--搜索-->
                <!--<div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info">第<b>1-1</b>条，共<b>2</b>条数据.</div></div></div>-->
                <div class="table-container">
                    <?php
                    $editableUrl = \yii\helpers\Url::to(['ajax-update', 'editable' => 1]);
                    echo $this->render('_search', ['model' => $searchModel, 'categories' => $categories]);
                    //Pjax::begin(['id'=>'pjax-container']);
                    echo GridView::widget([
                        'export'=>false,
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'dataTables_wrapper no-footer'],
                        'resizableColumns' => true,
                        //'floatHeader' => true,
                        //'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'hustshenl\metronic\widgets\CheckboxColumn', 'rowSelectedClass' => 'success selected'],
                            'id',
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute' => 'name',
                                'editableOptions' => [
                                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                    'formOptions' => ['action' => $editableUrl]
                                ],
                                'hAlign' => 'left',
                                'vAlign' => 'middle',
                                'format' => 'raw',
                            ],
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute' => 'category',
                                'editableOptions' => [
                                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                                    'data' => $categories,
                                    'formOptions' => ['action' => $editableUrl]
                                ],
                                'hAlign' => 'center',
                                'vAlign' => 'middle',
                                'format' => ['lookup', $categories],
                            ],
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute' => 'sort',
                                'editableOptions' => [
                                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                    'formOptions' => ['action' => $editableUrl]
                                ],
                                'hAlign' => 'left',
                                'vAlign' => 'middle',
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'status',
                                'format' => ['lookup', 'approveStatus'],
                            ],
                            [
                                'class' => 'hustshenl\metronic\widgets\ActionColumn',
                                'header' => Yii::t("member", '操作'),
                                'template' => "{:view} &nbsp; {:update} &nbsp; {:delete}",
                                'headerOptions' => ['width' => '100px', 'style' => 'text-align: center;'],
                                'contentOptions' => ['align' => 'center'],
                                'buttons' => [
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<span class="icon-trash"></span>', 'javascript:ChapterIndex.deleteItem(' . $key . ');');
                                    },
                                    'refresh' => function ($url, $model, $key) {
                                        return Html::a('<span class="icon-refresh"></span>', 'javascript:ChapterIndex.refreshItem(' . $key . ');');
                                    },
                                ]
                            ],
                        ],
                    ]);
                    //Pjax::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

