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
use kartik\widgets\FileInput;
use common\components\Upload;

/* @var $model member\models\forms\EditPassword */


$this->title = \Yii::t('member', 'Modify Password');
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
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <?php
                    $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                    ]);
                    echo Form::widget([ // continuation fields to row above without labels
                        'model' => $model,
                        'form' => $form,
                        'columns' => 1,
                        'attributes' => [
                            'username' => ['options' => ['disabled'=>true]],
                            //'sort' => ['options' => ['placeholder' => '排序值']],
                            'password' => [
                                'type' => Form::INPUT_PASSWORD,
                                'options' => []
                            ],
                            'newPassword' => [
                                'type' => Form::INPUT_PASSWORD,
                                'options' => []
                            ],
                            'password2' => [
                                'type' => Form::INPUT_PASSWORD,
                                'options' => []
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
                                    Button::widget(['label' => Yii::t('common', 'Save'), 'options' => ['type' => 'submit', 'class' => 'btn btn-primary']]) .' '.
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

