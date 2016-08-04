<?php

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Comic */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="comic-form">
    <div class="portlet-body">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'type' => ActiveForm::TYPE_VERTICAL,
            //'formConfig' => ['labelSpan' => 2]
        ]);

        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 3,
            //'columnOptions'=>['colspan'=>2],
            'attributes' => [
                'name' => ['options' => ['placeholder' => '漫画名称']],
                'alias' => ['options' => ['placeholder' => '漫画别名']],
                'title' => ['labelSpan' => 1, 'options' => ['placeholder' => '漫画标题，留空自动使用漫画名称']],
            ]
        ]);

        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'subjectIds' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'name' => 'color_1',
                        'data' => \common\models\base\Tag::comicSubjectArray(),
                        'options' => ['placeholder' => '选择或者输入新标签 ...', 'multiple' => true],
                        'pluginOptions' => [
                            'tags' => true,
                            'maximumInputLength' => 10
                        ],
                    ]
                ],
            ]
        ]);
        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 3,
            //'columnOptions'=>['colspan'=>2],
            'attributes' => [

                'category' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        //'name' => 'color_1',
                        'data' => \common\models\base\Category::categoriesArray(),
                        //'options' => ['placeholder' => '请选择分类 ...'],
                    ]
                ],
                'gender' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => ['data' => Yii::$app->params['lookup']['gender']],
                ],
                'age' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => ['data' => Yii::$app->params['lookup']['age']],
                ],
                'week' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => ['data' => Yii::$app->params['lookup']['week']],
                ],
                'color' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => ['data' => Yii::$app->params['lookup']['color']],
                ],
                'format' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => ['data' => Yii::$app->params['lookup']['format']],
                ],
                'serialise' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => Yii::$app->params['lookup']['serialise'],
                    'options' => ['inline' => true]
                ],
                'original_type' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => Yii::$app->params['lookup']['originalType'],
                    'options' => ['inline' => true]
                ],
                'authorize' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => Yii::$app->params['lookup']['authorize'],
                    'options' => ['inline' => true]
                ],
                'rtl' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '从右到左',
                            'offText' => '从左到右',
                        ],
                    ]
                ],
                'author_type' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '团队创作',
                            'offText' => '个人创作',
                        ],
                    ]
                ],
                'publish_type' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '首发作品',
                            'offText' => '非首发作品',
                        ],
                    ]
                ],

            ]
        ]);
        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'keywords' => ['options' => ['placeholder' => '关键字']],
                'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '漫画介绍','rows'=>5]],
                'notice' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '漫画公告','rows'=>5]],
            ]
        ]);

        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'actions' => [
                    'type' => Form::INPUT_RAW,
                    'value' => '<div style="text-align: center; margin-top: 20px">' .
                        Button::widget(
                            ['label' => $model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]
                        ) . ' ' .
                        Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) .
                        '</div>'
                ],
            ]
        ]);
        ActiveForm::end(); ?>
    </div>

    <!--    <div class="form-group text-center">
        <? /*= Button::widget(['label' => $model->isNewRecord ? Yii::t('member', 'Create') : Yii::t('member', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]
        ); */ ?>
        <? /*= Button::widget(['label' => Yii::t('common', 'Back'), 'options' => ['class' => 'btn default control-back']]); */ ?>
    </div>-->


</div>
