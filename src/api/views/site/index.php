<?php

use yii\helpers\Html;
use api\assets\AppAsset;

Yii::$app->controller->layout = false;
/** @var $this \yii\web\View */
/** @var $content string */
AppAsset::register($this);

// Initialize framework as per <code>icon-framework</code> param in Yii config
$this->beginPage();
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
    <title>欢迎使用圣樱漫画Api系统</title>
    <?php $this->head() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="MobileOptimized" content="320">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="/favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
<?php $this->beginBody() ?>
<div class="clearfix"></div>
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="text-center"> 欢迎使用圣樱漫画Api系统</div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php $this->endBody() ?>
</body>
<!-- END BODY -->
</html>
<?php $this->endPage() ?>

