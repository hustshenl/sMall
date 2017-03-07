<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\system\Model */

$this->title = Yii::t('admin', 'Create Model');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isModal = Yii::$app->request->get('mode','') == 'modal';
?>
<?= $isModal?
    \common\widgets\Modal::renderViewHeader($this->title).
    Html::beginTag('div', ['class' => 'modal-body']):
    Html::beginTag('div', ['class' => 'model-create']);
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
<?= Html::endTag('div');?>
