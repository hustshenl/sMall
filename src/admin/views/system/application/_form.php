<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model common\models\system\Application */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-form">

    <!-- BEGIN FORM-->
    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_LARGE]
    ]);

    echo Form::widget([ // continuation fields to row above without labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'name' => ['options' => ['placeholder' => '请输入应用名称...']],
            'identifier' => ['options' => ['placeholder' => '请输入应用唯一标识，建议使用小写字母，内置应用请填写appid...']],
            'description' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入应用描述...','rows'=>3]],
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
            'type' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => \common\models\system\Application::$types,
                    'options' => ['placeholder' => '应用类型'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ],
            'host' => ['options' => ['placeholder' => '请输入应用地址，例如：//www.small.shenl.com']],
            'ip' => ['options' => ['placeholder' => '请输入应用IP，例如：127.0.0.1']],
            'secret' => ['options' => ['placeholder' => '请输入应用密钥(SECRET)，留空自动生成，内置应用无需填写...']],
            'token' => ['options' => ['placeholder' => '请输入应用通信令牌(TOKEN)，留空自动生成，内置应用无需填写...']],
            'encrypt' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\SwitchInput',
                'options' => [
                    'containerOptions' => ['class' => ''],
                    'pluginOptions' => [
                        'onText' => '启用加密',
                        'offText' => '不加密',
                    ],
                ]
            ],
            'aes_key' => ['options' => ['placeholder' => '请输入AES加密密钥，留空自动生成，内置应用无需填写...']],
            'ssoConfig[status]' => [
                'label'=>'单点登陆状态',
                'data'=>isset($model->ssoConfig['status'])?$model->ssoConfig['status']:0,
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

            'ssoConfig[sign]' => ['label'=>'单点登陆路由', 'options' => ['placeholder' => '请输入单点登陆路由，留空默认为/sso/sign']],
            'ssoConfig[exit]' => ['label'=>'单点退出路由', 'options' => ['placeholder' => '请输入单点退出路由，留空默认为/sso/exit']],
            'remark' => ['options' => ['placeholder' => '备注信息，仅后台可见']],
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
