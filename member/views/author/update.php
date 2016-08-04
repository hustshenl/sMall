<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Author */

$this->title = Yii::t('member', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('member','author'),
]) . ' ' . $model->name;

$this->params['subTitle'] = $this->title ;
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    ['label' => Yii::t('member', 'Authors'), 'url' => ['author/index']],
    ['label' => $model->name, 'url' => ['view', 'id' => $model->id]],
    Yii::t('member', 'Update')
];

?>

    <div class="row author-update">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i><?= $this->params['subTitle'] ?>
                    </div>
                    <div class="actions btn-set">
                    </div>

                </div>
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
