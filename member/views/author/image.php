<?php

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Author */

$this->title = Yii::t('member', 'Update Image:') . ' ' . $model->name;

$this->params['subTitle'] = $this->title;
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    ['label' => Yii::t('member', 'Authors'), 'url' => ['author/index']],
    ['label' => $model->name, 'url' => ['view', 'id' => $model->id]],
    Yii::t('member', 'Update')
];

?>

<div class="row author-update">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i><?= $this->params['subTitle'] ?>
                </div>
                <div class="actions btn-set">
                </div>

            </div>
            <div class="row">
                <div class="col-xs-4">
                    <label>当前图片：</label>
                    <?php
                    echo empty($model)?'暂无图片':Yii::$app->formatter->asImage($model->image,['style'=>'width:100%;border: 1px solid lightgray;']);
                    ?>
                </div>
                <div class="col-xs-8">
                    <div class="author-form">

                        <?php
                        $form = ActiveForm::begin([
                            'options' => ['enctype' => 'multipart/form-data'],
                            'type' => ActiveForm::TYPE_VERTICAL,
                        ]);

                        $params = isset(Yii::$app->params['upload']['author'])?Yii::$app->params['upload']['author']:['width'=>1,'height'=>1];
                        $aspectRatio = ($params['width'] > 0 && $params['height'] > 0) ? $params['width'] / $params['height'] : 1;
                        echo Form::widget([ // continuation fields to row above without labels
                            'model' => $model,
                            'form' => $form,
                            'columns' => 1,
                            'attributes' => [
                                'image' => [
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
                                        Button::widget(
                                            ['label' => $model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]
                                        ) .
                                        Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                                        '</div>'
                                ],
                            ]
                        ]);
                        ?>

                        <!--<div class="form-group text-center">
                        </div>-->
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
            <div>

            </div>


        </div>
    </div>
</div>
