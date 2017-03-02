<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\helpers\SMall;
use seller\assets\AppAsset;

/* @var $this yii\web\View */

$this->title = '入驻申请';

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="callout callout-success lead">
                    <p>这里要增加入驻申请说明！</p>
                </div>
                <p><a class="btn btn-success" href="javascript:sso.verify(function(res) {console.log(res)}).done(function (res) {console.log(res);});">验证用户信息(弹窗)</a></p>
                <p><a class="btn btn-success" href="javascript:sso.verify().done(function (res) {console.log(res);}).fail(function(res) { console.log(res); });">验证用户信息(静默)</a></p>

                <p><?=Html::a('立即入驻',['apply'])?></p>
            </div>
        </div>

    </div>
</div>
