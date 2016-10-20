<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\AuthItem $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('content-header-actions'); ?>

<?= Html::a(Yii::t('rbac-admin', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>

<?= \common\widgets\Dialog::confirm(
    Yii::t('rbac-admin', 'Delete'),
    [
        'class' => 'btn btn-danger',
        'data-href'=>['delete', 'id' => $model->name],
        'data-mode'=>'confirm',
        'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
        'data-method' => 'post',
    ]
);?>
<?php $this->endBlock(); ?>
<div class="auth-item-view">

    <?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'className',
        ],
    ]);
    ?>
</div>
