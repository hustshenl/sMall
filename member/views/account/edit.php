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
use \kartik\widgets\DepDrop;

/* @var $model member\models\forms\EditPassword */

$this->title = \Yii::t('member', 'Edit Profile');
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
                <?php $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                ]);

                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'username' => ['options' => ['disabled' => true]],
                        'email' => ['options' => ['disabled' => true]],
                    ]
                ]);
                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'nickname' => ['options' => ['placeholder' => '请输入昵称']],
                        'gender' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'data' => Yii::$app->params['lookup']['genderStatus'],
                                'options' => ['placeholder' => '请选择性别 ...', 'multiple' => false],
                                'pluginOptions' => [
                                ],
                            ]],

                        'identity' => ['options' => ['placeholder' => '请输入真实姓名/工作室名称/机构名称']],
                        'identity_sn' => ['options' => ['placeholder' => '请输入身份证号/组织机构代码']],
                    ]
                ]);
                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'columns' => 3,
                    'attributes' => [
                        'phone' => ['options' => ['placeholder' => '请输入电话']],
                        'qq' => ['options' => ['placeholder' => '请输入昵称']],
                        'weibo' => ['options' => ['placeholder' => '请输入微博地址']],
                    ]
                ]);
                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'columns' => 3,
                    'attributes' => [
                        /*'province' => [
                            'labelSpan'=>1,
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'data' => \yii\helpers\ArrayHelper::map(\common\models\base\Region::find()->where(['lvl' => 1])->asArray()->all(), 'id', 'name'),
                                'options' => ['placeholder' => '请选择省份 ...', 'multiple' => false,'id'=>'province'],
                                'pluginOptions' => [
                                ],
                            ]
                        ],
                        'city' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => DepDrop::className(),
                            'options' => [
                                //'data' => [6 => 'Bank'],
                                'options' => ['placeholder' => '请选择城市 ...','id'=>'city'],
                                'type' => DepDrop::TYPE_SELECT2,
                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                'pluginOptions' => [
                                    'depends' => ['province'],
                                    'placeholder'=>'请选择城市 ...',
                                    'url' => \yii\helpers\Url::to(['region/city']),
                                    'loadingText' => '正在加载城市 ...',
                                ]
                            ],
                        ],
                        'district' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => DepDrop::className(),
                            'options' => [
                                //'data' => [6 => 'Bank'],
                                'options' => ['placeholder' => '请选择区县 ...'],
                                'type' => DepDrop::TYPE_SELECT2,
                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                'pluginOptions' => [
                                    'depends' => ['city'],
                                    'placeholder'=>'请选择城市 ...',
                                    'url' => \yii\helpers\Url::to(['region/district']),
                                    'loadingText' => '正在加载城市 ...',
                                ]
                            ],
                        ],*/
                        'province' => ['options' => ['placeholder' => '请输入省份/直辖市']],
                        'city' => ['options' => ['placeholder' => '请输入城市']],
                        'district' => ['options' => ['placeholder' => '请输入区县']],
                        'address' => ['options' => ['placeholder' => '请输入地址']],
                        'postcode' => ['options' => ['placeholder' => '请输入邮编']],
                    ]
                ]);
                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'signature' => [
                            'type' => Form::INPUT_TEXTAREA,
                            'options' => ['placeholder' => '请输入签名', 'row' => 3]],
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

