<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\store\Certification */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Certifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isModal = Yii::$app->request->get('mode', '') == 'modal' && Yii::$app->request->isAjax;
?>
<?= $isModal ?
    \common\widgets\Modal::renderViewHeader($this->title) .
    Html::beginTag('div', ['class' => 'modal-body']) :
    Html::beginTag('div', ['class' => 'certification-view']);
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'type',
            'name',
            'description',
            'icon',
            'price',
            'deposit',
            'expires_in',
            'sort',
            'reference',
            'created_at',
            'updated_at',
        ],
    ]) ?>

<?= Html::endTag('div'); ?>
