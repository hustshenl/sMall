<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/10/24
 * Time: 13:08
 */
/** @var $tab string */
use yii\helpers\Html;
?>

<ul class="nav nav-tabs">
    <li class="<?= $tab=='system'?'active':''?>"><?= Html::a('基本设置',['config/system']);?></li>
    <li class="<?= $tab=='mail'?'active':''?>"><?= Html::a('邮件设置',['config/mail']);?></li>
    <li class="<?= $tab=='sms'?'active':''?>"><?= Html::a('短信网关',['config/mail']);?></li>
</ul>
