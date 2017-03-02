<?php
use seller\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
\seller\assets\PluginAsset::register($this);

AppAsset::register($this);
$this->registerJsFile('@web/javascript/config');
$this->registerJsFile(\common\helpers\SMall::getResourceHost().'/js/sso.js',['depends'=>'passport\assets\AppAsset']);

$directoryPluginsAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/plugins');
$this->registerCssFile($directoryPluginsAsset.'/iCheck/square/blue.css');
$this->registerJsFile($directoryPluginsAsset.'/iCheck/icheck.min.js',['depends'=>\seller\assets\PluginAsset::className()]);
$this->registerJs("$('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page">

<?php $this->beginBody() ?>
<header>这里是页头</header>

    <?= $content ?>
<footer>这里是页脚</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
