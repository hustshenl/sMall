<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\system\ModelAttribute */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="model-attribute-form">

    <!-- BEGIN FORM-->
    <?php

    $validationUrl = ['attribute-validate','model_id'=>$model->model_id];
    $validationUrl['id'] = $model->isNewRecord?0:$model->id;
    $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'enableAjaxValidation' => true,
        'validationUrl' => \yii\helpers\Url::toRoute($validationUrl),
        'formConfig' => ['deviceSize' => ActiveForm::SIZE_LARGE], // 垂直排列时不要设置 'labelSpan' => 2,
    ]);

    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'name' => ['options' => ['placeholder' => '字段名称，建议使用小写字母...']],
            'label' => ['options' => ['placeholder' => '字段标签，中文...']],
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
            'is_key' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\SwitchInput',
                'options' => [
                    'containerOptions' => ['class' => ''],
                    'pluginOptions' => [
                        'onText' => '是',
                        'offText' => '否',
                    ],
                ]
            ],
            'required' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\SwitchInput',
                'options' => [
                    'containerOptions' => ['class' => ''],
                    'pluginOptions' => [
                        'onText' => '必填',
                        'offText' => '选填',
                    ],
                ]
            ],
            'default_value' => ['options' => ['placeholder' => '默认值...']],
            'length' => ['options' => ['placeholder' => '长度...']],
            'data_type' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'hideSearch' => true,
                    'data' => \common\models\system\ModelAttribute::$dataTypes,
                    'options' => ['placeholder' => '模型类型'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'input_type' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'hideSearch' => true,
                    'data' => \common\models\system\ModelAttribute::$inputTypes,
                    'options' => ['placeholder' => '模型类型'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'sort' => [
                //'label'=>false,
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\TouchSpin',
                'options' => [
                    'pluginOptions' => [
                        'buttonup_class' => 'btn btn-primary',
                        'buttondown_class' => 'btn btn-info',
                        //'step' => 10,
                        'max' => 999999999,
                        'min' => -999999999
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
            'description' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入应用描述...','rows'=>3]],
            'extra' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '选项内容使用英文逗号分隔...','rows'=>3]],
        ]
    ]);

    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'actions' => [
                'type' => Form::INPUT_RAW,
                'value' => '<div style="text-align: center; margin-top: 20px">' .
                    Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) . ' ' .
                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) .
                    '</div>'
            ],
        ]
    ]);
    ActiveForm::end();
    ?>
    <!-- END FORM-->

</div>
