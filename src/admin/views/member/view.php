<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\member\Member */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '会员详情';
$this->registerJsFile('@web/js/member.js', ['depends' => \admin\widgets\AppAsset::className()]);

?>

<?php $this->beginBlock('content-header-actions'); ?>
<?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

<?= \common\widgets\Dialog::confirm(
    Yii::t('rbac-admin', 'Delete'),
    [
        'class' => 'btn btn-danger',
        'data-href' => ['delete', 'id' => $model->id],
        'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
        'data-method' => 'post',
    ]
); ?>

<?php $this->endBlock(); ?>
<div class="member-view">
    <div class="member-view-body">
    <?= Html::button(Yii::t('admin', 'Test'), ['class' => 'btn btn-primary', 'id' => 'test',
        'data-url'=>\yii\helpers\Url::current()]) ?>

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
