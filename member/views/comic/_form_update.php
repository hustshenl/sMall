<?php

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Comic */
/* @var $tab string */
/* @var $form yii\widgets\ActiveForm */
//$action = Html::getInputName($model, 'tab');
$this->registerJs('ComicCreate.init();');
$this->registerJsFile("@web/js/comic/create.js", ['position' => $this::POS_END, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
$this->registerCssFile("@web/css/comic/create.css", ['position' => $this::POS_HEAD, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
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
                'columns' => 2,
                //'columnOptions'=>['colspan'=>2],
                'attributes' => [

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


                    'serialise' => [
                        'type' => Form::INPUT_RADIO_LIST,
                        'items' => Yii::$app->params['lookup']['serialise'],
                        'options' => ['inline' => true]
                    ],

                ]
            ]);
            echo Form::widget([ // continuation fields to row above without labels
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    //'keywords' => ['options' => ['placeholder' => '关键字']],
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
