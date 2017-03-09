<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\system\ModelAttribute */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'Model Attribute',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Model Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
$isModal = Yii::$app->request->get('mode', '') == 'modal'&&Yii::$app->request->isAjax;
?>
<?= $isModal ?
    \common\widgets\Modal::renderViewHeader($this->title) .
    Html::beginTag('div', ['class' => 'modal-body']) :
    Html::beginTag('div', ['class' => 'attribute-update']);
?>

<?= $this->render('_attribute-form', [
    'model' => $model,
]) ?>
<?= Html::endTag('div'); ?>
