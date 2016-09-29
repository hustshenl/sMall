<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel admin\models\member\member */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('admin', 'Create Member'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{view::bottom} {update} {delete}'
            ],
            'id',

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
<?php Pjax::end(); ?></div>
