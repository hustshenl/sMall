<?php

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Author */

$this->title = Yii::t('member', 'Update Notice');

$this->params['subTitle'] = $this->title ;


?>

    <div class="row author-update">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-volume-1"></i><?= $this->params['subTitle'] ?>
                    </div>
                    <div class="actions btn-set">
                    </div>

                </div>
                <div class="notice-form">

                    <?php
                    $form = ActiveForm::begin([
                        //'options' => ['enctype' => 'multipart/form-data'],
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                    ]);
                    echo Form::widget([ // continuation fields to row above without labels
                        'model' => $model,
                        'form' => $form,
                        'attributes' => [
                            'notice' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '请输入公告信息...（不超过1000字）', 'rows' => 4]],
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
    </div>
