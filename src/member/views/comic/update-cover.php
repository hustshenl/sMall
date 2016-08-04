<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\comic\Comic */

$this->title = Yii::t('member', 'Update Cover');
$this->params['subTitle'] = $this->title ;

?>
<div class="row comic-create">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-cloud-upload"></i><?= $this->params['subTitle'] ?>

                </div>
                <div class="actions btn-set">
                </div>

            </div>
            <?= $this->render('_form_cover', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
