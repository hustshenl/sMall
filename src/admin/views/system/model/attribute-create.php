<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\system\ModelAttribute */

$this->title = Yii::t('admin', 'Create Model Attribute');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Model Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isModal = Yii::$app->request->get('mode','') == 'modal';
?>
<?= $isModal?
    \common\widgets\Modal::renderViewHeader($this->title).
    Html::beginTag('div', ['class' => 'modal-body']):
    Html::beginTag('div', ['class' => 'attribute-create']);
?>

<?= $this->render('_attribute-form', [
    'model' => $model,
]) ?>
<?= Html::endTag('div');?>
