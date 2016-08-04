<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model member\models\comic\Comic */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories array */
?>

<div class="comic-search hide">

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
        'columns' => 6,
        //'columnOptions'=>['colspan'=>2],
        'attributes' => [

            'category' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => $categories,
                    'options' => ['placeholder' => '分类'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'serialise' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['serialise'],
                    'options' => ['placeholder' => '连载状态'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'commend' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['commendStatus'],
                    'options' => ['placeholder' => '推荐状态'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'status' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['approveStatus'],
                    'options' => ['placeholder' => '审核状态'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'is_original' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['originalStatus'],
                    'options' => ['placeholder' => '是否原创'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'gender' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['gender'],
                    'options' => ['placeholder' => '性别'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
            ],
            /*'year' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['year'],
                    'options' => ['placeholder' => '年份'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
            ],*/
            'age' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['age'],
                    'options' => ['placeholder' => '年龄'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
            ],
            'region' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['region'],
                    'options' => ['placeholder' => '地区'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]

                ],
            ],
            'week' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['week'],
                    'options' => ['placeholder' => '星期'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
            ],
            'color' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['color'],
                    'options' => ['placeholder' => '颜色'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
            ],
            'edition' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['edition'],
                    'options' => ['placeholder' => '版本'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
            ],
            'format' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->params['lookup']['format'],
                    'options' => ['placeholder' => '格式'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
            ],
        ]
    ]);
    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        //'columnOptions'=>['colspan'=>2],
        'attributes' => [
            'keywords' => ['options' => ['placeholder' => '搜索关键字']],
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div style="margin-top: 0px">' .
                    Html::submitButton(Yii::t('member', 'Search'), ['class' => 'btn btn-primary']) .
                    /*Button::widget(
                        ['label' => $model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]
                    ) .
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .*/
                    '</div>'
            ],
        ]
    ]);
    ActiveForm::end();
    ?>

</div>
