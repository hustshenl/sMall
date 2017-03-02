<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\user\User */

$this->title = Yii::t('seller', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('seller', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
