<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use \kartik\form\ActiveForm;
use \kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'class' => 'common\widgets\ActionColumn',
        'template' => '{update::_self} {delete}'
    ],
    $usernameField,
    'nickname',
    'phone',
    'email',
    [
        'attribute' => 'permission',
        'label' => Yii::t('admin', '用户组/权限'),
        'value' => function ($model, $key, $index, $column) {
            $permission = array_keys($model->permission);
            if (empty($permission)) return Yii::t('admin', 'Empty');
            return implode(',', $permission);
        },
    ],
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
/*$columns[] = [
    'class' => 'common\widgets\ActionColumn',
    'template' => '{:update} {:delete}'
];*/

$this->beginBlock('content-header-actions');
echo Html::a(Yii::t('admin', 'Create Admin'), ['create'], ['class' => 'btn btn-success']);
$this->endBlock();
?>
<div class="assignment-index">
    <?php Pjax::begin(); ?>
    <div class="admin-search">

        <?php
        $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showErrors' => true,
                'showLabels' => false,
            ],
            'action' => ['index'],
            'method' => 'get',
        ]);
        echo Form::widget([ // continuation fields to row above without labels
            'model' => $searchModel,
            'form' => $form,
            'columns' => 3,
            'attributes' => [

                /*'category' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data' => Yii::$app->params['lookup']['authorCategory'],
                        'options' => ['placeholder' => '分类'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]
                ],
                'status' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data' => Yii::$app->params['lookup']['userStatus'],
                        'options' => ['placeholder' => '状态'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]
                ],
                'vip' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data' => Yii::$app->params['lookup']['vipStatus'],
                        'options' => ['placeholder' => '是否VIP'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]
                ],*/
                'keyword' => ['options' => ['placeholder' => '用户名/手机号/Email']],
                'actions' => [
                    'type' => Form::INPUT_RAW,
                    'value' => '<div>' .
                        Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) .
                        '</div>'
                ],
            ]
        ]);
        ActiveForm::end();
        ?>

    </div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $columns,
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
<!-- Modal -->
