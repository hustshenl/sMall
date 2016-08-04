<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
//use hustshenl\metronic\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Author */

$this->title = '认证信息';
$this->params['subTitle'] = $this->title ;
/*$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    ['label' => Yii::t('member', 'Authors'), 'url' => ['author/index']],
    $this->params['subTitle']
];*/

?>

<div class="row author-view">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i><span
                        class="caption-subject bold uppercase"><?= $this->params['subTitle'] ?></span>
                </div>
                <div class="actions">
                </div>

            </div>
            <div class="portlet-body form">

                <div class="row">
                    <div class="col-xs-12"><p>恭喜，您已经通过认证！认证信息如下，若需修改，请联系客服！</p></div>
                </div>
                <!--搜索-->
                <!--<div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info">第<b>1-1</b>条，共<b>2</b>条数据.</div></div></div>-->
                <div class="table-container">
                    <?= DetailView::widget([
                        'model' => $model,
                        //'template' => '<tr><th width="100">{label}</th><td>{value}</td></tr>',
                        'attributes' => [
                            //'id',
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'name',
                                        'valueColOptions' => ['style' => 'width:30%'],
                                        'displayOnly' => true
                                    ],
                                    [
                                        'attribute' => 'nickname',
                                        'valueColOptions' => ['style' => 'width:30%'],
                                        'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: middle;'],
                                        'displayOnly' => true
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'description',
                                        'valueColOptions' => ['style' => 'width:80%'],
                                        'displayOnly' => true
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'image',
                                        'format'=>['image',['style'=>'width:10em;border: 1px solid lightgray;']],
                                        'valueColOptions' => ['style' => 'width:80%'],
                                        'displayOnly' => true
                                    ],
                                ],
                            ],

                            //'count',

                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

