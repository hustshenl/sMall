<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\user\User */

$this->title = Yii::t('admin', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
