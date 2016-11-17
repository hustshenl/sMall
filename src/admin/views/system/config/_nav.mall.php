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
    <li class="<?= $tab=='mall'?'active':''?>"><?= Html::a('商城设置',['system/config/mall']);?></li>
    <li class="<?= $tab=='mail'?'active':''?>"><?= Html::a('商城其他',['system/config/mall']);?></li>
</ul>
