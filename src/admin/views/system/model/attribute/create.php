<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\system\ModelAttribute */

$this->title = Yii::t('admin', 'Create Model Attribute');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Model Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
