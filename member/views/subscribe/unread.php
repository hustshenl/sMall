<?php

//use yii;
use yii\helpers\Html;
use kartik\grid\GridView;
use hustshenl\metronic\widgets\CheckboxColumn;
use hustshenl\metronic\widgets\Button;
use hustshenl\metronic\widgets\ButtonDropdown;
use yii\widgets\Pjax;

//use kartik\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel member\models\member\Subscribe */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories array */

$this->title = \Yii::t('member', 'Unread Subscribes');
$this->params['subTitle'] = $this->title;
/*$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Subscribes'), 'url' => ['index']],
    $this->params['subTitle']
];*/
//$this->registerJs('SinMH.handleSearchForm("#btn-search",".comic-search");SubscribeIndex.init();');
//$this->registerJsFile("@web/js/comic/index.js",['position'=>$this::POS_END,'depends'=>[\hustshenl\metronic\bundles\ThemeAsset::className()]]);

?>

<div class="row subscribe-index">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-heart"></i><span
                        class="caption-subject bold uppercase"><?= $this->params['subTitle'] ?></span>
                </div>
                <div class="actions">
                    <?= Html::a(Yii::t('member', '全部标记为已读'), ['subscribe/read-all'], ['class' => 'btn btn-success',
                        'title' => \Yii::t('yii', 'Delete'),
                        'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]); ?> &nbsp;
                </div>

            </div>
            <div class="portlet-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li><a href="<?= \yii\helpers\Url::to(['/subscribe']); ?>">全部订阅</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['subscribe/read']); ?>">已读更新</a></li>
                        <li class="active"><a href="javascript:void(0);">未读更新</a></li>
                    </ul>
                    <div class="tab-content no-space">
                        <?php
                        Pjax::begin(['id'=>'pjax-container']);
                        echo \yii\widgets\ListView::widget([
                            //'options' => ['class'=>'clearfix'],
                            'dataProvider' => $dataProvider,
                            'layout' => "{summary}\n<div class='items clearfix'>{items}</div>\n{pager}",
                            'itemOptions' => ['class' => 'list-item-subscribe col-xs-12 col-sm-3'],
                            'itemView' => 'list-item',
                        ]);
                        Pjax::end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCssFile('@web/css/subscribe.css', ['position' => $this::POS_HEAD, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
?>
