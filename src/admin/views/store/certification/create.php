<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\store\Certification */

$this->title = Yii::t('admin', 'Create Certification');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Certifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->expires_in = 86400*365;

$isModal = Yii::$app->request->get('mode','') == 'modal';
?>
<?= $isModal?
    \common\widgets\Modal::renderViewHeader($this->title).
    Html::beginTag('div', ['class' => 'modal-body']):
    Html::beginTag('div', ['class' => 'certification-create']);
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
<?= Html::endTag('div');?>
