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
// TODO 获取公钥
/** @var \common\components\base\Config $config */
$config = Yii::$app->config;
$rsaPubKey = $config->get('ras','publicKey');
ob_start();
echo <<<JS
var keys = function () {
    return {
        rsa:'$rsaKey',
    };
}();
JS;
//$temp = ob_get_contents();
ob_end_flush();
//写入文件
//$fp = fopen(Yii::getAlias('@webroot/js/config.js'), 'w');
//fwrite($fp, $temp);

?>