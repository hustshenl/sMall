<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model \common\models\store\Certification */
/* @var $searchModel admin\models\store\CertificationItem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Certification Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Certifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->blocks['hideTitle'] = false;



$this->beginBlock('content-header-actions');
echo \yii\bootstrap\Modal::widget([
    'id' => 'contact-modal',
    'toggleButton' => [
            'header'=>'aaa',
        'label' => '创建项目',
        'class' => 'btn btn-success',
        'data-target' => '#contact-modal',
        'href' => \yii\helpers\Url::toRoute(['item-create','id'=>$model->id]),
    ],
    'clientOptions' => false,
]);
echo Html::a(Yii::t('admin', 'Create Certification Item'), ['item-create','id'=>$model->id], ['class' => 'btn btn-success']);
$this->endBlock();
?>
<div class="certification-item-index">

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'export' => false,
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'certification_id',
            'status',
            'type',
            'name',
            // 'label',
            // 'required',
            // 'notice',
            // 'items',
            // 'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>