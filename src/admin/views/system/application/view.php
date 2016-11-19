<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\system\Application */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content-header-actions'); ?>
<?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

<?= \common\widgets\Dialog::confirm(
    Yii::t('rbac-admin', 'Delete'),
    [
        'class' => 'btn btn-danger',
        'data-href' => ['delete', 'id' => $model->id],
        'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
        'data-method' => 'post',
    ]
); ?>

<?php $this->endBlock(); ?>

<div class="application-view">

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
                        'attribute'=>'name',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'displayOnly'=>true
                    ],
                    [
                        'attribute'=>'identifier',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly'=>true
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'status',
                        'format'=>'raw',
                        'value'=> $model->status?
                            '<span class="label label-success">启用</span>'
                            :'<span class="label label-danger">禁用</span>',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'displayOnly'=>true
                    ],
                    [
                        'attribute'=>'type',
                        'format'=>'raw',
                        'value'=> $model->type == \common\models\system\Application::TYPE_PRESET?
                            '<span class="label label-info">内置应用</span>'
                            :'<span class="label label-info">外部应用</span>',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly'=>true
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'host',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'displayOnly'=>true
                    ],
                    [
                        'attribute'=>'ip',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly'=>true
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'id',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'displayOnly'=>true
                    ],
                    [
                        'attribute'=>'secret',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly'=>true
                    ],
                ],
            ],
            'token',
            [
                'columns' => [
                    [
                        'attribute'=>'encrypt',
                        'format'=>'raw',
                        'value'=> $model->encrypt?
                            '<span class="label label-success">启用加密</span>'
                            :'<span class="label label-danger">未加密</span>',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'displayOnly'=>true
                    ],
                    [
                        'attribute'=>'aes_key',
                        'valueColOptions'=>['style'=>'width:30%'],
                        'labelColOptions'=>['style'=>'width: 20%; text-align: right; vertical-align: middle;'],
                        'displayOnly'=>true
                    ],
                ],
            ],
            'description',
            'remark',

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



            [
                'group'=>true,
                'label'=>'SECTION 2: 单点登陆',
                'rowOptions'=>['class'=>'info']
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'sso',
                        'label'=>'单点登陆状态',
                        'format'=>'raw',
                        'value'=> isset($model->ssoConfig['status'])&&$model->ssoConfig['status']?
                            '<span class="label label-success">启用</span>'
                            :'<span class="label label-danger">未启用</span>',
                        'valueColOptions'=>['style'=>'width:20%'],
                        'displayOnly'=>true
                    ],
                    [
                        'attribute'=>'sso',
                        'label'=>'单点登陆路由',
                        'value'=> isset($model->ssoConfig['sign'])? $model->ssoConfig['sign'] :'',
                        'valueColOptions'=>['style'=>'width:20%'],
                        'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                        'displayOnly'=>true
                    ],
                    [
                        'attribute'=>'sso',
                        'label'=>'单点退出路由',
                        'value'=> isset($model->ssoConfig['exit'])? $model->ssoConfig['exit'] :'',
                        'valueColOptions'=>['style'=>'width:20%'],
                        'labelColOptions'=>['style'=>'width: 10%; text-align: right; vertical-align: middle;'],
                        'displayOnly'=>true
                    ],
                ],
            ],

            //'link',
        ],
    ]) ?>

</div>
