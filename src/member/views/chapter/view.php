<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use common\models\comic\Chapter;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Chapter */
/* @var $comic common\models\comic\Comic */

$this->title = $comic->name.'/'.$model->name.'/'.Yii::t('member','Preview');
$this->params['subTitle'] = $this->title;
/*$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    ['label' => $comic->name, 'url' => ['comic/view', 'id' => $comic->id]],
    $this->params['subTitle']
];*/

?>

<div class="row chapter-view">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-notebook"></i><?= Html::encode($this->title) ?>
                </div>
                <div class="actions btn-set">
                    <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('member', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>

            </div>
            <div class="portlet-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'condensed' => true,
                    'enableEditMode' => false,
                    'hover' => true,
                    'mode' => DetailView::MODE_VIEW,
                    'attributes' => [
                        [
                            'group' => true,
                            'label' => 'SECTION 1: 基本信息',
                            'rowOptions' => ['class' => 'info']
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'name',
                                    'valueColOptions' => ['style' => 'width:20%'],
                                    'displayOnly' => true
                                ],
                                [
                                    'attribute' => 'image_mode',
                                    'format'=>'raw',
                                    'value'=> $model->image_mode == Chapter::MODE_DOUBLE?
                                        '<span class="label label-success">双页模式</span>'
                                        :'<span class="label label-danger">单页模式</span>',
                                    'valueColOptions' => ['style' => 'width:20%'],
                                    'labelColOptions' => ['style' => 'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly' => true
                                ],
                                [
                                    'attribute' => 'rtl',
                                    'format'=>'raw',
                                    'value'=> $model->rtl == Chapter::RTL_R?
                                        '<span class="label label-success">从右到左</span>'
                                        :'<span class="label label-danger">从左到右</span>',
                                    'valueColOptions' => ['style' => 'width:20%'],
                                    'labelColOptions' => ['style' => 'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly' => true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'category',
                                    'format'=>['lookup',\common\models\comic\ChapterCategory::categoriesArray()],
                                    'valueColOptions' => ['style' => 'width:20%'],
                                    'displayOnly' => true
                                ],
                                [
                                    'attribute' => 'sort',
                                    'valueColOptions' => ['style' => 'width:20%'],
                                    'labelColOptions' => ['style' => 'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly' => true
                                ],
                                [
                                    'attribute' => 'is_vip',
                                    'format'=>'raw',
                                    'value'=> $model->is_vip?
                                        '<span class="label label-danger">VIP章节</span>'
                                        :'<span class="label label-success">非VIP章节</span>',
                                    'valueColOptions' => ['style' => 'width:20%'],
                                    'labelColOptions' => ['style' => 'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly' => true
                                ],
                            ],
                        ],

                        [
                            'group' => true,
                            'label' => 'SECTION 2: 版权跳转',
                            'rowOptions' => ['class' => 'info'.(empty($model->link)?' hide':'')],
                        ],
                        [
                            'rowOptions' => ['class' => 'info'.(empty($model->link)?' hide':'')],
                            'columns' => [
                                [
                                    'attribute' => 'link_name',
                                    'valueColOptions' => ['style' => 'width:20%'],
                                    'displayOnly' => true,
                                ],
                                [
                                    'attribute' => 'link',
                                    'valueColOptions' => ['style' => 'width:40%'],
                                    'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                                    'displayOnly' => true
                                ],
                            ],
                        ],
                        [
                            'group' => true,
                            'label' => 'SECTION 2: 漫画图片',
                            'rowOptions' => ['class' => 'info'.(empty($model->link)?'':' hide')],
                        ],
                        [
                            'label'=>false,
                            'value'=> $model->imageHtml,
                            'format'=>'raw',
                            'labelColOptions' => ['style' => 'display:none;'],
                            'displayOnly'=>true
                        ],

                    ],
                ]) ?>

            </div>


        </div>
    </div>
</div>