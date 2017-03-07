<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel admin\models\system\ModelAttribute */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Model Attributes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-attribute-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('admin', 'Create Model Attribute'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'model_id',
            'status',
            'name',
            'label',
            // 'sort',
            // 'data_type',
            // 'input_type',
            // 'default_value',
            // 'length',
            // 'is_key',
            // 'required',
            // 'extra',
            // 'description',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
