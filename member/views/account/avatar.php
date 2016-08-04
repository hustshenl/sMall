<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/17 17:37
 * @Description:
 */

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $model member\models\forms\EditPassword */
$this->title = \Yii::t('member', 'Modify Avatar');
$this->params['subTitle'] = $this->title;
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Profile'),
        'url' => ['account/index']],
    $this->params['subTitle']
];
//注册控制JS
$this->registerJs('$(".control-back").click(function(){
window.history.back();
});');

?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i><?= $this->params['subTitle'] ?>
                </div>
                <div class="actions btn-set">

                </div>

            </div>
            <div class="portlet-body row">
                <div class="col-md-4 col-xs-12">
                    <label><?=\Yii::t('member', 'Current Avatar');?>:</label>
                    <?php
                    echo empty($model) ? \Yii::t('member', 'Current Avatar') : Yii::$app->formatter->asImage($model->avatar, ['style' => 'width:100%;border: 1px solid lightgray;','default'=>'images/default/avatar.png']);
                    ?>
                </div>
                <div class="col-md-8 col-xs-12">
                    <!-- BEGIN FORM-->
                    <?php
                    $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data'],
                        'type' => ActiveForm::TYPE_VERTICAL,
                    ]);
                    $params = isset(Yii::$app->params['upload']['avatar']) ? Yii::$app->params['upload']['avatar'] : ['width' => 1, 'height' => 1];
                    $aspectRatio = ($params['width'] > 0 && $params['height'] > 0) ? $params['width'] / $params['height'] : 1;
                    echo Form::widget([ // continuation fields to row above without labels
                        'model' => $model,
                        'form' => $form,
                        'columns' => 1,
                        'attributes' => [
                            'avatar' => [
                                'label' => '',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => '\hustshenl\cropper\Cropper',
                                'options' => [
                                    'data' => '',
                                    'label' => \Yii::t('common', 'Chose Image'),
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
                                    Button::widget(['label' => Yii::t('common', 'Save'), 'options' => ['type' => 'submit', 'class' => 'btn btn-primary']]) . ' ' .
                                    Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                                    '</div>'
                            ],
                        ]
                    ]);

                    ActiveForm::end();
                    ?>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
</div>

