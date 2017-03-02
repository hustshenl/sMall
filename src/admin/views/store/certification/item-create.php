<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\store\CertificationItem */
/* @var $certification \common\models\store\Certification */

$this->title = Yii::t('admin', 'Create Certification Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Certifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $certification->name, 'url' => ['view', 'id' => $certification->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certification-create">

    <?= $this->render('_item-form', [
        'model' => $model,
    ]) ?>

</div>
