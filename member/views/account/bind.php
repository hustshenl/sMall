<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \member\models\forms\LoginForm */

$this->title = \Yii::t('member', 'Bind Account');
$this->params['breadcrumbs'][] = $this->title;
//注册控制JS

?>


<?php
\yii\widgets\Pjax::begin();
$form = ActiveForm::begin(['id' => 'login-form',
    'options' => ['class' => 'login-form',],
    'type' => ActiveForm::TYPE_VERTICAL,
]); ?>
<h3 class="form-title"><?= Html::encode($this->title) ?></h3>
<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
</div>
<?= $form->field($model, 'username', [
    'showLabels'=>false,
    'addon' => ['prepend' => ['content'=>'<i class="fa fa-user fa-fw"></i>']],
])->input('text',['placeholder'=>Yii::t('member', 'Input Username')])  ?>
<?= $form->field($model, 'password', [
    'showLabels'=>false,
    'addon' => ['prepend' => ['content'=>'<i class="fa fa-lock fa-fw"></i>']],
])->passwordInput(['placeholder'=>Yii::t('member', 'Input Password')]) ?>
<?= $form->field($model, 'rememberMe')->checkbox() ?>
<div class="form-actions">
    <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
    <?= Html::a('Forgot Password?', ['account/request-password-reset'], ['class' => 'forget-password']) ?>
    <!--<a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>-->
</div>
<div class="create-account">
    <p> <?= Html::a(Yii::t('member','Don\'t have an account yet ?'),['account/register']); ?>&nbsp;
        <?= Html::a(Yii::t('member','Create an account'),['account/register']); ?>
    </p>
</div>

<?php ActiveForm::end();
\yii\widgets\Pjax::end();
?>
