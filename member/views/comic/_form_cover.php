<?php

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Comic */
/* @var $step string */
/* @var $form yii\widgets\ActiveForm */
$nextTab = [
    'general' => 'meta',
    'meta' => 'cover',
    'cover' => 'category',
    'category' => 'tags',
    'tags' => 'etc',
    'etc' => 'view',
];
$this->registerJs('ComicCreate.init();');
$this->registerJsFile("@web/js/comic/create.js", ['position' => $this::POS_END, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
$this->registerCssFile("@web/css/comic/create.css", ['position' => $this::POS_HEAD, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
?>

<div class="comic-form">
    <div class="portlet-body">
        <div class="clearfix" id="comic-cover" data-key="<?= $model->id; ?>">
            <div class="col-sm-2 text-center col-current-cover">
                <div class="row text-center">
                    <div class="col-sm-12"
                         style="border-bottom: 1px solid #ccc; padding-bottom: .5em;margin-bottom: .5em;">
                        当前封面
                    </div>
                    <div class="col-sm-12" id="current-cover">
                        <?= Yii::$app->formatter->asImage($model->cover); ?>
                    </div>
                    <div class="col-sm-12">
                        <?= Button::widget(['label' => Yii::t('member', '删除'), 'options' => [
                            'class' => 'btn btn-danger remove-cover',
                            'data-key' => $model->id
                        ]]); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-history-image">
                <div class="row text-center">
                    <div class="col-sm-12"
                         style="border-bottom: 1px solid #ccc; padding-bottom: .5em;margin-bottom: .5em;">
                        历史封面（最多4个）
                    </div>
                    <?php
                    foreach ($model->covers as $key => $cover) {
                        if ($key > 3) break;
                        ?>
                        <div
                            class="col-sm-3 history-image <?= $cover->url == $model->cover ? 'active' : ''; ?>"
                            data-key="<?= $cover->id; ?>">
                            <div class="row">
                                <?= Yii::$app->formatter->asImage($cover->url); ?>
                            </div>
                            <div class="row">
                                <?/*= Button::widget(['label' => Yii::t('member', '通过'), 'options' => ['class' => 'btn btn-primary approve-cover',]]); */ ?>
                                <?= Button::widget(['label' => Yii::t('member', '使用'), 'options' => ['class' => 'btn btn-success apply-cover',]]); ?>
                                <?= Button::widget(['label' => Yii::t('member', '删除'), 'options' => ['class' => 'btn btn-danger remove-image']]); ?>
                                <?/*= Button::widget(['label' => Yii::t('member', '拒绝'), 'options' => ['class' => 'btn btn-danger reject-cover']]); */ ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="form-body">
            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'type' => ActiveForm::TYPE_VERTICAL,
                //'action'=>$action,
                //'formConfig' => ['labelSpan' => 2]
            ]);

            $params = isset(Yii::$app->params['upload']['cover'])?Yii::$app->params['upload']['cover']:['width'=>1,'height'=>1];
            $aspectRatio = ($params['width'] > 0 && $params['height'] > 0) ? $params['width'] / $params['height'] : 1;

            echo Form::widget([ // continuation fields to row above without labels
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'cover' => [
                        'label' => '',
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\hustshenl\cropper\Cropper',
                        'options' => [
                            'data' => '',
                            'label' => '选择图片',
                            'pluginOptions' => [
                                'aspectRatio' => $aspectRatio,
                            ],
                        ]
                    ],

                ]
            ]);


            echo Form::widget([ // continuation fields to row above without labels
                'model' => $model,
                'form' => $form,
                'attributes' => [
                    'actions' => [
                        'type' => Form::INPUT_RAW,
                        'value' => '<div style="text-align: center; margin-top: 20px">' .
                            Button::widget(['label' => Yii::t('common', 'Next'), 'options' => ['type' => 'submit', 'class' => 'btn btn-primary']]) .
                            Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                            '</div>'
                    ],
                ]
            ]);
            ActiveForm::end(); ?>
        </div>
    </div>


    <!--    <div class="form-group text-center">
        <? /*= Button::widget(['label' => $model->isNewRecord ? Yii::t('member', 'Create') : Yii::t('member', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]
        ); */ ?>
        <? /*= Button::widget(['label' => Yii::t('common', 'Back'), 'options' => ['class' => 'btn default control-back']]); */ ?>
    </div>-->


</div>
