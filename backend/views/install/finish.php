<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '安装完成';
?>
<div class="site-index">

    <div>
        <h1>恭喜，安装完成</h1>

        <p class="lead">恭喜，圣樱漫画管理系统已经安装完成.</p>
        <p class="text-danger">开始使用之前，请添加后台管理员.</p>
        <p>
            <?=Html::a('网站首页',Yii::$app->params['domain']['frontend'],['class'=>'btn btn-primary']); ?>
            <?=Html::a('管理后台',Yii::$app->params['domain']['admin'],['class'=>'btn btn-success']); ?>
            <?=Html::a('添加管理员',['/'],['class'=>'btn btn-danger']); ?>
        </p>

    </div>

</div>
