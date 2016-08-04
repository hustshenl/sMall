<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model common\models\comic\Author */

$this->title = Yii::t('member', 'Author Auth');
$this->params['subTitle'] = $this->title ;
/*$this->params['breadcrumbs']['links'] = [
    $this->params['subTitle']
];*/
?>

<div class="row author-create">
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
