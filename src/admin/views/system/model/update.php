<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\system\Model */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
        'modelClass' => 'Model',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');

$isModal = Yii::$app->request->get('mode', '') == 'modal'&&Yii::$app->request->isAjax;
?>
<?= $isModal ?
    \common\widgets\Modal::renderViewHeader($this->title) .
    Html::beginTag('div', ['class' => 'modal-body']) :
    Html::beginTag('div', ['class' => 'model-update']);
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
<?= Html::endTag('div'); ?>
