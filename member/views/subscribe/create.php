<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\member\Subscribe */

$this->title = Yii::t('common', 'Create Subscribe');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Subscribes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscribe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
