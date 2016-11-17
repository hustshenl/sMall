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
    <li class="<?= $tab=='system'?'active':''?>"><?= Html::a('基本设置',['system/config/index']);?></li>
    <li class="<?= $tab=='mail'?'active':''?>"><?= Html::a('邮件设置',['system/config/mail']);?></li>
    <li class="<?= $tab=='sms'?'active':''?>"><?= Html::a('短信网关',['system/config/mail']);?></li>
    <li class="<?= $tab=='rsa'?'active':''?>"><?= Html::a('RSA设置',['system/config/rsa']);?></li>
</ul>
