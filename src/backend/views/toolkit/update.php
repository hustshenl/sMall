<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/17 17:37
 * @Description:
 */
use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
//use hustshenl\metronic\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

$this->title = \Yii::t('backend', 'Update Admin');
$this->params['subTitle'] = \Yii::t('backend', 'Update Admin');
$this->params['breadcrumbs'] = [
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
                    <!--<i class="icon-settings"></i>--><? /*= $this->params['subTitle'] */ ?>
                </div>
                <div class="actions btn-set">

                </div>

            </div>
            <?php
            echo $this->render('_form_admin', ['model' => $model]);
            ?>
        </div>
    </div>
</div>

