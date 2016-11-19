<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use passport\assets\AppAsset;
use common\widgets\Alert;
use common\helpers\SMall;

AppAsset::register($this);
\kartik\icons\Icon::map($this,\kartik\icons\Icon::FA);
$this->registerCssFile('@web/css/login.css',['depends'=>'passport\assets\AppAsset']);
$this->registerJsFile('@web/javascript/config');
$this->registerJsFile(SMall::getResourceHost().'/js/lib/jsencrypt.js',['depends'=>'passport\assets\AppAsset']);
$this->registerJsFile(SMall::getResourceHost().'/js/lib/security.js',['depends'=>'passport\assets\AppAsset']);
$this->registerJsFile(SMall::getResourceHost().'/js/sso.js',['depends'=>'passport\assets\AppAsset']);
//$this->registerJsFile('@web/js/login.js',['depends'=>'passport\assets\AppAsset']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <nav class="navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">My Company</a></div>
            <div  class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-right nav">
                    <li><a href="#">Link</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
