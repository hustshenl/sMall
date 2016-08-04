<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\helpers\SMall;

/* @var $this yii\web\View */

$this->title = '后台控制台';
if (function_exists('gd_info')) {
    $gd = gd_info();
    $gd = $gd['GD Version'];
} else {
    $gd = "不支持";
}
$domains = ArrayHelper::getValue(Yii::$app->params, 'domain');
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="callout callout-success lead">
                    <p>欢迎使用后台管理系统！</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="box-title caption">
                            <i class="fa fa-member"></i><span class="caption-subject bold uppercase">系统信息</span>
                        </div>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">操作系统：<?= PHP_OS; ?></div>
                            <div class="col-xs-6">主机名：<?= $_SERVER['SERVER_NAME']; ?></div>
                            <div class="col-xs-6">
                                IP端口：<?= $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT']; ?></div>
                            <div class="col-xs-6">运行环境：<?= $_SERVER["SERVER_SOFTWARE"]; ?></div>
                            <div class="col-xs-6">PHP运行方式：<?= php_sapi_name(); ?></div>
                            <div class="col-xs-12">MYSQL
                                Client版本：<?=  Yii::$app->db->pdo->getAttribute(PDO::ATTR_CLIENT_VERSION); ?></div>
                            <div class="col-xs-12">MYSQL
                                Server版本：<?= Yii::$app->db->pdo->getAttribute(PDO::ATTR_SERVER_VERSION); ?></div>
                            <div class="col-xs-6">GD库版本：<?= $gd; ?></div>
                            <div class="col-xs-6">
                                register_globals：<?= get_cfg_var("register_globals") == "1" ? "ON" : "OFF"; ?></div>
                            <div class="col-xs-6">上传附件限制：<?= ini_get('upload_max_filesize'); ?></div>
                            <div class="col-xs-6">执行时间限制：<?= ini_get('max_execution_time') . "秒"; ?></div>
                            <div class="col-xs-6">
                                剩余空间：<?= round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M'; ?></div>
                            <!--<div class="col-xs-6">采集函数检测：<? /*= ini_get('allow_url_fopen') ? '支持' : '不支持';*/ ?></div>-->
                            <div class="col-xs-6">采集函数检测：<?= function_exists('curl_init') ? '支持' : '不支持'; ?></div>
                            <div class="col-xs-6">服务器时间：<?= date("Y年n月j日 H:i:s"); ?></div>
                            <div class="col-xs-6">北京时间：<?= gmdate("Y年n月j日 H:i:s", time() + 8 * 3600); ?></div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="box-title caption">
                            <i class="fa fa-member"></i><span class="caption-subject bold uppercase">程序信息</span>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <p class="col-xs-12">程序版本：<span
                                    class="label label-success"><?= SMall::versionName(); ?></span>
                            </p>
                            <div class="col-xs-12">商城前台：<?= ArrayHelper::getValue($domains, 'frontend'); ?></div>
                            <div class="col-xs-12">用户中心：<?= ArrayHelper::getValue($domains, 'member'); ?></div>
                            <div class="col-xs-12">后台管理：<?= ArrayHelper::getValue($domains, 'admin'); ?></div>
                            <div class="col-xs-12">API地址：<?= ArrayHelper::getValue($domains, 'api'); ?></div>
                            <div class="col-xs-12">资源地址：<?= ArrayHelper::getValue($domains, 'resource'); ?></div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-8">
                <?= Html::a('官方网站', 'http://small.shenl.com', ['class' => 'btn btn-danger', 'target' => '_blank']); ?>
                <?= Html::a('使用手册@osc', 'http://git.oschina.net/shenl/SinMH-2.0-Guide', ['class' => 'btn btn-success', 'target' => '_blank']); ?>
                <?= Html::a('官方论坛@osc', 'http://git.oschina.net/shenl/SinMH-2.0-Guide/issues', ['class' => 'btn btn-info', 'target' => '_blank']); ?>
            </div>
        </div>

    </div>
</div>
