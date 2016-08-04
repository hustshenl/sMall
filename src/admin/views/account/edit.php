<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/17 17:37
 * @Description:
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = \Yii::t('admin', '修改资料');
$this->params['subTitle'] = Yii::$app->user->identity->username;

$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['/account']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
//注册控制JS
$this->registerJs('$(".control-back").click(function(){
window.history.back();
});');

?>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title caption">
                        <i class="icon-settings"></i><?= $this->params['subTitle'] ?>
                    </div>
                    <div class="actions btn-set">

                    </div>

                </div>
                <div class="box-body form">
                    <!-- BEGIN FORM-->
                    <?php $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                    ]); ?>
                    <?= $form->field($model, 'username',['inputOptions'=>['class' => 'form-control','disabled'=>true]]) ?>
                    <?= $form->field($model, 'email',['inputOptions'=>['class' => 'form-control','disabled'=>true]]) ?>
                    <?= $form->field($model, 'nickname') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'newPassword')->passwordInput() ?>
                    <?= $form->field($model, 'password2')->passwordInput() ?>
                    <?= $form->field($model, 'phone') ?>
                    <div class="form-group text-center">
                        <?= Html::submitButton(Yii::t('common', 'Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
                        <?= Html::resetButton(Yii::t('common', 'Back'), ['class' => 'btn default control-back']); ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>

