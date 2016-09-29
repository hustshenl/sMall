<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
\common\widgets\PluginAsset::register($this);
$directoryPluginsAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/plugins');
$this->registerCssFile($directoryPluginsAsset.'/iCheck/square/blue.css');
$this->registerJsFile($directoryPluginsAsset.'/iCheck/icheck.min.js',['depends'=>\common\widgets\PluginAsset::className()]);
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

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
