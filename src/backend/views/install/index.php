<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '安装';
?>
<div class="site-index">

    <div>
        <h1>开始安装!</h1>

        <p class="lead">安装前请阅读安装说明，配置好相关文件后点击开始安装.</p>

        <p>环境要求：</p>
        <p>PHP>=5.4</p>
        <p>Mysql>=5.5</p>
        <p>IIS>=7.5 | Apache | Nginx</p>
        <p>请确认环境符合安装要求</p>
        <p><?=Html::a('开始安装',['install/create-db'],['class'=>'btn btn-success']); ?></p>

    </div>

</div>
