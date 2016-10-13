<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use common\widgets\AdvanceSearch;

/* @var $this yii\web\View */
/* @var $model admin\models\member\member */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="member-search">

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
        'model' => $model,
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
            'username' => ['options' => ['placeholder' => '用户名/手机号/Email']],
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div>' .
                    Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) . ' ' .
                    Html::button(Yii::t('common', '高级筛选'), ['class' => 'btn btn-info advance-search-trigger']) .
                    '</div>'
            ],
        ]
    ]);
    ActiveForm::end();
    ?>

</div>

<?php
$advanceForm = AdvanceSearch::begin([
    'trigger' => '.advance-search-trigger',
    'action' => ['index'],
    'method' => 'get',
]);
echo Form::widget([ // continuation fields to row above without labels
    'model' => $model,
    'form' => $advanceForm,
    'columns' => 1,
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
        'username' => ['options' => ['placeholder' => '搜索名称']],
        'email' => ['options' => ['placeholder' => '搜索Email']],
        'status' => ['options' => ['placeholder' => '搜索Email']],
        'nickname' => ['options' => ['placeholder' => '搜索Email']],
        'phone' => ['options' => ['placeholder' => '搜索Email']],
        'actions' => [
            'type' => Form::INPUT_RAW,
            'value' => '<div>' .
                Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) . ' ' . ' ' .
                Html::button(Yii::t('common', '关闭'), ['class' => 'btn default advance-search-trigger']) .
                '</div>'
        ],
    ]
]);
AdvanceSearch::end();
?>
