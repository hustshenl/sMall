<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\store\Certification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certification-form">

    <?php $form = ActiveForm::begin();


    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
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
                    'data' => [0=>'禁用',10=>'正常'],
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
            'name' => ['options' => ['placeholder' => '认证名称']],
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '认证描述']],
            'status' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\SwitchInput',
                'options' => [
                    'containerOptions' => ['class' => ''],
                    'pluginOptions' => [
                        'onText' => '启用',
                        'offText' => '禁用',
                    ],
                ]
            ],
            'category' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => $model::$categories,
                    'options' => ['placeholder' => '分类'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'icon' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\FileInput::className(),
                'options' => [
                    //'placeholder' => '图片地址',
                    'pluginOptions' => [
                        'initialPreview' => empty($model->icon) ? false : Yii::$app->formatter->asImage($model->icon, ['class' => 'file-preview-image']),
                        //'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        //'browseClass' => 'btn btn-primary btn-block',
                        //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' => '选择图片'
                    ],

                ]
            ],
            'formPrice' => ['label' => '认证价格（元）', 'options' => ['format'=>'price','placeholder' => '认证价格（元）']],
            'formDeposit' => ['label' => '保证金（元）', 'options' => ['placeholder' => '保证金（元）']],
            'formExpiresIn' => ['label' => '有效期', 'options' => ['placeholder' => '有效期']],
            'reference' => ['label' => '引用页', 'options' => ['placeholder' => '引用内容地址，http://']],
            'sort' => [
                //'label'=>false,
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\TouchSpin',
                'options' => [
                    'pluginOptions' => [
                        'buttonup_class' => 'btn btn-primary',
                        'buttondown_class' => 'btn btn-info',
                        'step' => 10,
                        'max' => 999999999,
                        'min' => -999999999
                    ],
                ]
            ],
            //'content' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '认证内容']],
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div>' .
                    Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) . ' ' .
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                    '</div>'
            ],
        ]
    ]);

    ?>

    <?php ActiveForm::end(); ?>

</div>
