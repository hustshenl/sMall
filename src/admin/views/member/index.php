<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\member\member */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Members');
$this->params['breadcrumbs'][] = $this->title;
$this->blocks['hideTitle'] = false;
$this->registerJs(<<<JS
yii.actionColumn.onLoad = {};
JS
);
$this->registerJsFile('@web/js/member.js',['depends'=>\admin\widgets\AppAsset::className()]);


$this->beginBlock('content-header-actions');
echo Html::a(Yii::t('admin', 'Create Member'), ['create'], ['class' => 'btn btn-success']);
echo ' '.Html::button(Yii::t('common', '多选'), ['class' => 'btn btn-info multi-select']);
echo ' '.Html::button(Yii::t('common', '高级筛选'), ['class' => 'btn btn-info advance-search-trigger']);
$this->endBlock(); ?>

<div class="member-index">
    <?php
    $editableUrl = '';
    Pjax::begin(['id' => 'pjax-content']);
    echo $this->render('_search', ['model' => $searchModel]);
    ?>
    <?= GridView::widget([
        'export' => false,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'kartik\grid\CheckboxColumn', 'rowSelectedClass' => 'success selected'],
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{view::bottom} {update} {delete}'
            ],
            'id',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'username',
                'value' => 'username',
                /*'readonly'=>function($model, $key, $index, $widget) {
                    return (!$model->status); // do not allow editing of inactive records
                },*/
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'pjaxContainerId' => 'pjax-content',
                    'formOptions' => ['action' => $editableUrl]
                ],

                //'hAlign' => 'left',
                //'vAlign' => 'middle',
                //'width' => '100px',
                'format' => 'raw',
                //'pageSummary' => true
            ],

            'status',
            'username',
            'nickname',
            //'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            // 'access_token',
            // 'identity',
            // 'identity_sn',
            // 'qq',
            'email:email',
            'phone',
            // 'weibo',
            // 'address',
            // 'postcode',
            // 'scores',
            // 'grade',
            // 'credit',
            // 'vip',
            // 'vip_scores',
            // 'vip_expires',
            // 'role',
            // 'gender',
            // 'district',
            // 'city',
            // 'province',
            // 'country',
            // 'language',
            // 'avatar',
            // 'signature',
            // 'remark',
            // 'register_ip',
            // 'login_at',
            // 'login_ip',
            // 'created_at',
            // 'updated_at',

        ],
    ]); ?>
    <?php
    Pjax::end();
    ?></div>
