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

$this->title = \Yii::t('admin', '清理缓存');

$this->params['breadcrumbs'][] = $this->title;
//注册控制JS
//$this->registerJsFile("@web/js/config/form.js", ['position' => $this::POS_END, 'depends' => [\admin\widgets\AppAsset::className()]]);
//$this->registerJs('ConfigForm.initEvents("#cache-all",false,"#cache-parts");');

?>

<div class="cache-clean">
    <div class="cache-clean-form">
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
                'all' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '全部',
                            'offText' => '部分',
                        ],
                    ]
                ],
            ]
        ]);

        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'options' => ['id' => 'cache-parts'],
            'attributes' => [
                'parts' => [
                    'items' => [
                        'hust.shenl.small.passport.page.javascript'=> '通行证JS缓存',
                    ],
                    'type' => Form::INPUT_CHECKBOX_LIST,
                ]
            ]
        ]);
        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'actions' => [
                    'type' => Form::INPUT_RAW,
                    'value' => '<div style="text-align: center; margin-top: 20px">' .
                        Html::submitButton(Yii::t('admin', '开始清理'), ['class' => 'btn btn-primary']) . ' ' .
                        Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) .
                        '</div>'
                ],
            ]
        ]);
        ActiveForm::end();
        ?>
        <!-- END FORM-->
    </div>
</div>

<?php
//$this->registerJs('ConfigForm.init();');
?>

