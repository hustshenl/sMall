<?php
use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \admin\models\forms\Admin */

$this->title = \Yii::t('rbac-admin', 'Create Admin');;
$this->params['subTitle'] = $this->title;

$this->params['breadcrumbs'][] = $this->title;
/*
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('rbac-admin', 'Assignments'), 'url' => ['index']],
    $this->params['subTitle']
];*/
?>

<div class="row">
    <div class="col-md-12">
        <div class="form">
                <!-- BEGIN FORM-->
                <?php $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                ]);
                $userListUrl = \yii\helpers\Url::to(['users','role'=>\common\models\access\User::ROLE_USER]);
                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'attributes' => [
                        'user_id' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'options' => ['placeholder' => '请选择用户 ...', 'multiple' => false],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 1,
                                    'ajax' => [
                                        'url' => $userListUrl,
                                        'dataType' => 'json',
                                        'data' => new \yii\web\JsExpression('function(params) { return {username:params.term}; }')
                                    ],
                                    'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new \yii\web\JsExpression('function(item) {var res = item.username;if(item.phone !=null&&item.phone != "") res += " / Tel: "+item.phone;if(item.email !=null&&item.email != "") res += " / Email: "+item.email;return res; }'),
                                    'templateSelection' => new \yii\web\JsExpression(<<<JS
function(item) {
    var res = item.username||item.text;
    if(item.phone !=null&&item.phone != "") res += " / Tel: "+item.phone;
    if(item.email !=null&&item.email != "") res += " / Email: "+item.email;
    console.log(item,res);
    return res; 
}
JS
                                    ),
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
                                \yii\bootstrap\Button::widget(
                                    ['label' => Yii::t('common', 'Create'), 'options' => ['type' => 'submit', 'class' => 'btn btn-success']]
                                ) .
                                Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                                '</div>'
                        ],
                    ]
                ]);

                ActiveForm::end(); ?>
                <!-- END FORM-->
            </div>
    </div>
</div>
