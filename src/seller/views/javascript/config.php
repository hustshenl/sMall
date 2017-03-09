<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/11/11
 * Time: 12:59
 */
use \yii\helpers\ArrayHelper;
use \yii\helpers\Json;

/* @var $this yii\web\View */
/* @var \common\components\system\Config $config */
$config = Yii::$app->config;
$passportHost = \common\helpers\SMall::getPassportHost();
ob_start();
echo <<<JS
var config = {
    version:'1.0.0',
    sso:{
        host:'$passportHost',
    }
};
JS;
//$temp = ob_get_contents();
ob_end_flush();
//写入文件
//$fp = fopen(Yii::getAlias('@webroot/js/config.js'), 'w');
//fwrite($fp, $temp);

?>