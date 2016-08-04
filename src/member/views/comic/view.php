<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use common\models\access\User;
use \common\models\base\Category;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Comic */

$this->title = $model->name;
$this->params['subTitle'] = \Yii::t('common', 'View');
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['index']],
    ['label' => $model->name, 'url' => ['view', 'id' => $model->id]],
    $this->params['subTitle']
];
$tab = 'general';
$regions = Category::categoriesArray(Category::TYPE_REGION);
$years = Category::categoriesArray(Category::TYPE_YEAR);
?>


<div class="row comic-view">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-notebook"></i><?= Html::encode($this->title) ?>
                </div>
                <div class="actions btn-set">
                    <?= Html::a(Yii::t('member', '新增章节'), ['chapter/create', 'comic_id' => $model->id], ['class' => 'btn btn-success']) ?>
                    <?= Html::a(Yii::t('member', '查看章节'), ['chapter/index', 'comic_id' => $model->id], ['class' => 'btn btn-info']) ?>
                    <?= Html::a(Yii::t('member', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('member', 'Delete'), ['delete', 'id' => $model->id], [
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
                    'condensed'=>true,
                    'enableEditMode'=> false,
                    'hover'=>true,
                    'mode'=>DetailView::MODE_VIEW,
                    'attributes' => [
                        [
                            'group'=>true,
                            'label'=> 'SECTION 1: 基本信息',
                            'rowOptions'=>['class'=>'info']
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'title',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'slug',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'letter',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'name',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'alias',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'original_name',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'author',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'label'=>'上传用户',
                                    'value'=> $model->user?$model->user->username:'系统',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'editor_id',
                                    'value'=> $model->editor?$model->editor->username:'系统',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'is_vip',
                                    'format'=>'raw',
                                    'value'=> $model->is_vip?
                                        '<span class="label label-danger">VIP漫画</span>'
                                        :'<span class="label label-success">普通漫画</span>',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'free_num',
                                    'value'=> $model->free_num>0?$model->free_num:'全部免费',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'post_num',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'mark',//
                                    'format'=>'raw',
                                    'value'=> "<span class='badge' style='background-color: {$model->mark}'> </span>  <code>" . $model->mark . '</code>',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'weight',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'scores',
                                    'format'=>['price',2,''],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],

                        [
                            'group'=>true,
                            'label'=>'SECTION 2: 漫画状态',
                            'rowOptions'=>['class'=>'info']
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'status',
                                    'format'=>'raw',
                                    'value'=> $model->status?
                                        '<span class="label label-success">已审核</span>'
                                        :'<span class="label label-danger">待审核</span>',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'commend',
                                    'format'=>'raw',
                                    'value'=> $model->commend?
                                        '<span class="label label-danger">已经推荐</span>'
                                        :'<span class="label label-success">未推荐</span>',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'serialise',
                                    'format'=>'raw',
                                    'value'=> $model->serialise == \common\models\comic\Comic::STATUS_FINISHED?
                                        '<span class="label label-danger">已完结</span>'
                                        :'<span class="label label-success">连载中</span>',
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],

                        [
                            'group'=>true,
                            'label'=>'SECTION 3: 分类信息',
                            'rowOptions'=>['class'=>'info']
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'category',
                                    'format'=>['lookup',\common\models\base\Category::categoriesArray()],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'gender',
                                    'format'=>['lookup','gender'],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'age',
                                    'format'=>['lookup','age'],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'region',
                                    'format'=>['lookup',$regions],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'week',
                                    'format'=>['lookup','week'],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'color',
                                    'format'=>['lookup','color'],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'edition',
                                    'format'=>['lookup','edition'],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'format',
                                    'format'=>['lookup','format'],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'year',
                                    'format'=>['lookup',$years],
                                    'valueColOptions'=>['style'=>'width:20%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],

                        [
                            'group'=>true,
                            'label'=>'SECTION 4: 详细信息',
                            'rowOptions'=>['class'=>'info']
                        ],
                        'cover:image',
                        'keywords',
                        'description',
                        [
                            'group'=>true,
                            'label'=>'SECTION 5: 其他信息',
                            'rowOptions'=>['class'=>'info']
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'next_post',
                                    'format'=>['datetime','php:Y年m月d日'],
                                    'valueColOptions'=>['style'=>'width:30%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'next_chapter',
                                    'valueColOptions'=>['style'=>'width:30%'],
                                    'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'last_chapter_name',
                                    'valueColOptions'=>['style'=>'width:30%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'last_chapter_id',
                                    'valueColOptions'=>['style'=>'width:30%'],
                                    'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'created_at',
                                    'format'=>['datetime','php:Y年m月d日'],
                                    'valueColOptions'=>['style'=>'width:30%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'updated_at',
                                    'format'=>['datetime','php:Y年m月d日'],
                                    'valueColOptions'=>['style'=>'width:30%'],
                                    'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        //'click',
                        [
                            'columns' => [
                                [
                                    'attribute'=>'click',
                                    'valueColOptions'=>['style'=>'width:10%'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'click_daily',
                                    'valueColOptions'=>['style'=>'width:10%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'click_weekly',
                                    'valueColOptions'=>['style'=>'width:10%'],
                                    'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                                [
                                    'attribute'=>'click_monthly',
                                    'valueColOptions'=>['style'=>'width:10%'],
                                    'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute'=>'link',
                                    'format'=>'url',
                                    'value'=>empty($model->link)?null:$model->link,
                                    'valueColOptions'=>['style'=>'width:80%'],
                                    'displayOnly'=>true
                                ],
                            ],
                        ],
                        //'link',
                    ],
                ]) ?>

            </div>


        </div>
    </div>
</div>
