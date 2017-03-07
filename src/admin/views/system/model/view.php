<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\system\Model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$isModal = Yii::$app->request->get('mode', '') == 'modal'&&Yii::$app->request->isAjax;
?>
<?= $isModal ?
    \common\widgets\Modal::renderViewHeader($this->title) .
    Html::beginTag('div', ['class' => 'modal-body']) :
    Html::beginTag('div', ['class' => 'model-view']);
?>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'status',
            'type',
            'table',
            'description',
            'sort',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <?= Html::endTag('div'); ?>
