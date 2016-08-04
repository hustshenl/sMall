<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Chapter */

$this->title = $model->name;
$this->params['subTitle'] =  $comic->name. '/' . $model->name.'/'. Yii::t('member', 'Update');
/*$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['comic/index']],
    ['label' => $comic->name, 'url' => ['comic/view', 'id' => $comic->id]],
    $this->params['subTitle']
];*/
?>


<div class="row chapter-update">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i><?= $this->params['subTitle'] ?>
                </div>
                <div class="actions btn-set">
                </div>

            </div>
            <?php
            $categories = \common\models\comic\ChapterCategory::categoriesArray();
            echo $this->render('_form', ['model' => $model, 'categories' => $categories]);
            ?>

        </div>
    </div>
</div>
