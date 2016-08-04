<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\AdminForm */

$this->title = \Yii::t('backend', 'Create Admin');;
$this->params['subTitle'] = \Yii::t('backend', 'Create Admin');
$this->params['breadcrumbs'] = [
    $this->params['subTitle']
];
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i><? /*= $this->title */ ?>
                </div>
                <div class="actions btn-set">

                </div>

            </div>
            <?php
            echo $this->render('_form_admin', ['model' => $model]);
            ?>
        </div>
    </div>
</div>
