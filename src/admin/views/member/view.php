<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\member\Member */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('admin', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('admin', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('admin', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="action-ajax-content">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'username',
            'nickname',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'access_token',
            'identity',
            'identity_sn',
            'qq',
            'email:email',
            'phone',
            'weibo',
            'address',
            'postcode',
            'scores',
            'grade',
            'credit',
            'vip',
            'vip_scores',
            'vip_expires',
            'role',
            'gender',
            'district',
            'city',
            'province',
            'country',
            'language',
            'avatar',
            'signature',
            'remark',
            'register_ip',
            'login_at',
            'login_ip',
            'created_at',
            'updated_at',
        ],
    ]) ?>


</div>
</div>
