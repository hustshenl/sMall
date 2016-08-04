<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \member\models\forms\LoginForm */

$this->title = Yii::t('member', 'Sign In');
$this->params['breadcrumbs'][] = $this->title;
//注册控制JS
$redirect_uri = Yii::$app->request->get('redirect_uri');
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
<?/*= $form->field($model, 'rememberMe')->checkbox() */?>
<div class="form-actions">
    <?= Html::submitButton(Yii::t('member', 'Login'), ['class' => 'btn btn-success', 'data-pjax'=>0]) ?>
    <?= Html::a(Yii::t('member', 'Forgot Password?'), ['account/request-password-reset'], ['class' => 'forget-password']) ?>
    <!--<a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>-->
</div>
<div class="login-options">
    <h4><?=Yii::t('member', 'Or login with')?></h4>
    <ul class="social-icons">
        <li style="text-indent: 0;">
            <?= Html::a('<i class="fa fa-qq"></i>',['account/auth','authclient'=>'qq','redirect_uri'=>$redirect_uri],['data-pjax'=>0]); ?>
        </li>
        <li style="text-indent: 0;">
            <?= Html::a('<i class="fa fa-weixin"></i>',['account/auth','authclient'=>'weixin','redirect_uri'=>$redirect_uri],['data-pjax'=>0]); ?>
        </li>
        <li style="text-indent: 0;">
            <?= Html::a('<i class="fa fa-weibo"></i>',['account/auth','authclient'=>'weibo','redirect_uri'=>$redirect_uri],['data-pjax'=>0]); ?>
        </li>
    </ul>
</div>
<div class="create-account">
    <p> <?= Yii::t('member','Don\'t have an account yet ?'); ?>&nbsp;
        <?= Html::a(Yii::t('member','Create an account'),['account/register']); ?>
    </p>
</div>

<?php ActiveForm::end();
\yii\widgets\Pjax::end();
?>
