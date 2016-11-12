<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/17 17:37
 * @Description:
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this \yii\web\View */
/** @var \admin\models\configs\SystemConfig $model */

$this->title = \Yii::t('admin', 'System Config');
$this->params['subTitle'] = \Yii::t('admin', 'Base Config');
//注册控制JS
/*$this->registerJsFile("@web/js/config/form.js", ['position' => $this::POS_END, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);*/
//$this->registerJs('ConfigForm.initEvents("#baseform-status",false,"#close-message");');

?>

<div class="config-index">
    <div class="nav-tabs-custom">
        <?= $this->render('_nav.system.php',['tab'=>'rsa']);?>
        <div class="tab-content">
            <p class="text-muted well well-sm no-shadow">
                提示信息：RSA加密用于用户登陆。
            </p>
            <div class="tab-pane active" id="tab_1">
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
                        'status' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\SwitchInput',
                            'options' => [
                                'containerOptions' => ['class' => ''],
                                'pluginOptions' => [
                                    'onText' => '开启',
                                    'offText' => '关闭',
                                ],
                            ]
                        ],

                        'publicKey' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入网站描述，用于首页描述显示...','rows'=>3]],
                        'privateKey' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入网站描述，用于首页描述显示...','rows'=>3]],
                    ]
                ]);

                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'attributes' => [
                        'actions' => [
                            'type' => Form::INPUT_RAW,
                            'value' => '<div style="text-align: center; margin-top: 20px">' .
                                \yii\bootstrap\Button::widget(['label' => Yii::t('common', 'Save'), 'options' => ['type' => 'submit', 'class' => 'btn btn-primary']]) . ' ' .
                                Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) .
                                '</div>'
                        ],
                    ]
                ]);
                ActiveForm::end();
                ?>
                <!-- END FORM-->
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
</div>

<?php
//$this->registerJs('ConfigForm.init();');
?>

