<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('content-header-actions'); ?>

<?= Html::a(Yii::t('rbac-admin', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

<?= \common\widgets\Dialog::confirm(
    Yii::t('rbac-admin', 'Delete'),
    [
        'class' => 'btn btn-danger',
        'data-href'=>['delete', 'id' => $model->id],
        'data-mode'=>'confirm',
        'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
        'data-method' => 'post',
    ]
);?>
<?php $this->endBlock(); ?>
<div class="menu-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'menuParent.name:text:Parent',
            'name',
            'route',
            'order',
        ],
    ])
    ?>

</div>
