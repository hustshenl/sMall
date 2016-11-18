<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\system\Application */

$this->title = Yii::t('admin', 'Create Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
