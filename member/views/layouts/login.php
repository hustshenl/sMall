<?php

use yii\helpers\Html;
use hustshenl\metronic\helpers\Layout;
use hustshenl\metronic\widgets\Menu;
use hustshenl\metronic\widgets\NavBar;
use hustshenl\metronic\widgets\Nav;
use hustshenl\metronic\widgets\Breadcrumbs;
use hustshenl\metronic\widgets\Button;
use hustshenl\metronic\widgets\HorizontalMenu;
use hustshenl\metronic\Metronic;
use member\widgets\Badge;
use member\assets\LoginAsset;

$this->beginPage();
Metronic::registerThemeAsset($this);
LoginAsset::register($this);
//$this->registerJs('App.init();Login.init();');
?>
    <!DOCTYPE html>
    <!--[if IE 8]>
    <html lang="<?= Yii::$app->language ?>" class="ie8 no-js"> <![endif]-->
    <!--[if IE 9]>
    <html lang="<?= Yii::$app->language ?>" class="ie9 no-js"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="<?= Yii::$app->language ?>" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta name="renderer" content="webkit">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta name="MobileOptimized" content="320">
        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="login" >
    <?php $this->beginBody() ?>
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="menu-toggler sidebar-toggler">
    </div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="/account/login">
            <img src="<?= Yii::getAlias('@web').'/images/logo.png'; ?>" alt=""/>
        </a>
    </div>
    <!-- END LOGO -->

    <?=
    (Metronic::getComponent()->layoutOption == Metronic::LAYOUT_BOXED) ?
        Html::beginTag('div', ['class' => 'container']) : '';
    ?>
    <!-- BEGIN CONTAINER -->
    <div class="content">
        <!-- BEGIN CONTENT -->
        <?= $content ?>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="copyright">
        <?= \yii\helpers\ArrayHelper::getValue(Yii::$app->config->get('siteInfo'),'siteCopyright','2014-'.date('Y').' &copy; SHENL.COM.'); ?>
    </div>
    <?= (Metronic::getComponent()->layoutOption == Metronic::LAYOUT_BOXED) ? Html::endTag('div') : ''; ?>
    <?php $this->endBody() ?>
    </body>
    <!-- END BODY -->
    </html>
<?php $this->endPage() ?>