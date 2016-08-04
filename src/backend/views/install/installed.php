<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '已经安装';
?>
<div class="site-index">
    <div>
        <h1>已经安装!</h1>
        <p class="lead">您已经安装过了！</p>
        <p>若需要重新安装，需要执行以下操作.</p>
        <p>1、清空数据库.</p>
        <p>2、删除@backend/runtime/install.lock文件.</p>
        <p>3、然后重新访问本页面.</p>
        <?=Html::a('网站首页',Yii::$app->params['domain']['frontend'],['class'=>'btn btn-primary']); ?>
        <?=Html::a('管理后台',Yii::$app->params['domain']['admin'],['class'=>'btn btn-success']); ?>
        <?=Html::a('添加管理员',['/'],['class'=>'btn btn-danger']); ?>
    </div>
</div>
