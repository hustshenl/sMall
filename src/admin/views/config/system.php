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
        <?= $this->render('_nav.system.php',['tab'=>'system']);?>
        <div class="tab-content">
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
                        'siteName' => ['options' => ['placeholder' => '请输入网站名称，每页标题后面会加上此标识...']],
                        'siteUrl' => ['options' => ['placeholder' => '请输入网站名称...']],
                        'siteTitle' => ['options' => ['placeholder' => '请输入网站标题，用于首页标题显示...']],
                        'siteSlogan' => ['options' => ['placeholder' => '请输入网站标语，部分主题可能用到...']],
                        'siteKeywords' => ['options' => ['placeholder' => '请输入网站关键字，用于首页关键字显示...']],
                        'siteDescription' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入网站描述，用于首页描述显示...','rows'=>3]],
                        'adminEmail' => ['options' => ['placeholder' => '请输入管理员Email...']],
                        'adminQQ' => ['options' => ['placeholder' => '请输入管理员QQ...']],
                        'icpSN' => ['options' => ['placeholder' => '请输入ICP 备案号...']],
                        'headerCode' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入页面头部自定义代码...','rows'=>3]],
                        'footerCode' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入脚部自定义代码...','rows'=>3]],
                        'socialCommentCode' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入社会化评论代码...','rows'=>3]],
                        'socialShareCode' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入社会化分享代码...','rows'=>3]],
                        'siteCopyright' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入网站版权信息...','rows'=>3]],
                        'status' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\SwitchInput',
                            'options' => [
                                'containerOptions' => ['class' => ''],
                                'pluginOptions' => [
                                    'onText' => '运行中',
                                    'offText' => '关闭',
                                ],
                            ]
                        ],
                    ]
                ]);

                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'options' => ['id' => 'close-message'],
                    'attributes' => [
                        'message' => ['type'=>Form::INPUT_TEXTAREA,'options' => ['placeholder' => '请输入网站网站关闭原因...','rows'=>3]],
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

