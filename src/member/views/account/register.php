<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \member\models\forms\LoginForm */

$this->title = Yii::t('member', 'Register');
$this->params['breadcrumbs'][] = $this->title;
//注册控制JS

?>


<?php
\yii\widgets\Pjax::begin();
$form = ActiveForm::begin(['id' => 'signup-form',
    'options' => ['class' => 'signup-form',],
    //'label'=>false,

]); ?>
<h3 class="form-title"><?= Html::encode($this->title) ?></h3>
<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
</div>
<?= $form->field($model, 'email', [
    'showLabels'=>false,
    'addon' => ['prepend' => ['content'=>'<i class="fa fa-envelope fa-fw"></i>']],
])->input('email',['placeholder'=>Yii::t('member', 'Input Email')]) ?>
<?= $form->field($model, 'username', [
    'showLabels'=>false,
    'addon' => ['prepend' => ['content'=>'<i class="fa fa-user fa-fw"></i>']],
])->input('text',['placeholder'=>Yii::t('member', 'Input Username')])  ?>
<?= $form->field($model, 'password', [
    'showLabels'=>false,
    'addon' => ['prepend' => ['content'=>'<i class="fa fa-lock fa-fw"></i>']],
])->passwordInput(['placeholder'=>Yii::t('member', 'Input Password')]) ?>
<?= $form->field($model, 'password2', [
    'showLabels'=>false,
    'addon' => ['prepend' => ['content'=>'<i class="fa fa-check fa-fw"></i>']],
])->passwordInput(['placeholder'=>Yii::t('member', 'Input Password again')]) ?>
<div class="form-actions">
    <?= Html::submitButton(Yii::t('member', 'Register'), ['class' => 'btn btn-success', 'data-pjax' => 0]) ?>
</div>
<div class="create-account">
    <p> <?= Yii::t('member', 'Has an account ?')?>&nbsp;
        <?= Yii::$app->session->get('auth_id',false)?Html::a(Yii::t('member', 'Bind'),['account/bind']) :Html::a(Yii::t('member', 'Login'),['account/login']); ?>
        <!--<a href="javascript:;" id="register-btn"> 直接登陆 </a>-->
    </p>
</div>

<?php ActiveForm::end();
\yii\widgets\Pjax::end();
?>