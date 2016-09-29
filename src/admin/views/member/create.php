<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\member\Member */

$this->title = Yii::t('admin', 'Create Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
