<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model common\models\base\Category */

$this->title = Yii::t('member', 'Create Chapter Category');
$this->params['subTitle'] = $this->title ;
$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    ['label' => Yii::t('member', 'Chapter Categories'), 'url' => ['category/index']],
    $this->params['subTitle']
];
?>

<div class="row category-create">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i><?= $this->params['subTitle'] ?>
                </div>
                <div class="actions btn-set">
                </div>

            </div>
            <?= $this->render('_form_category', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
