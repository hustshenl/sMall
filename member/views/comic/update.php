<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Comic */
/* @var $tab string */


$this->title =  $model->name . '/' . Yii::t('member', 'Update');
$this->params['subTitle'] = $model->name . '/' . Yii::t('member', 'Update');
/*
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    ['label' => $model->name, 'url' => ['view', 'id' => $model->id]],
    $this->params['subTitle']
];*/

?>

<div class="row comic-update">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i><?= $this->title ?>
                </div>
                <div class="actions btn-set">
                </div>

            </div>
            <?= $this->render('_form_update', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>