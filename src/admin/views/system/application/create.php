<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\system\Application */

$this->title = Yii::t('admin', 'Create Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isModal = Yii::$app->request->get('mode', '') == 'modal'&&Yii::$app->request->isAjax;
?>
<?= $isModal ?
    \common\widgets\Modal::renderViewHeader($this->title) .
    Html::beginTag('div', ['class' => 'modal-body']) :
    Html::beginTag('div', ['class' => 'application-create']);
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?= Html::endTag('div'); ?>
