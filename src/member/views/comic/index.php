<?php

//use yii;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use hustshenl\metronic\widgets\CheckboxColumn;
use hustshenl\metronic\widgets\Button;
use hustshenl\metronic\widgets\ButtonDropdown;
use yii\widgets\Pjax;
use \member\models\comic\Comic;

//use kartik\grid\CheckboxColumn;


/* @var $this yii\web\View */
/* @var $searchModel member\models\comic\Comic */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories array */

$this->title = \Yii::t('member', 'My Comics');
$this->params['subTitle'] = $this->title;
/*$this->params['breadcrumbs']['links'] = [
    ['label' => \Yii::t('member', 'Comics'), 'url' => ['index']],
    $this->params['subTitle']
];*/
//$this->registerJs('SinMH.handleSearchForm("#btn-search",".comic-search");ComicIndex.init();');
//$this->registerJsFile("@web/js/comic/index.js",['position'=>$this::POS_END,'depends'=>[\hustshenl\metronic\bundles\ThemeAsset::className()]]);
$status = Yii::$app->request->get('status', -2);

?>

<div class="row comic-index">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i><span
                        class="caption-subject bold uppercase"><?= $this->params['subTitle'] ?></span>
                </div>
                <div class="actions">
                    &nbsp;
                    <?= Html::a(Yii::t('member', '新增漫画'), ['create'], ['class' => 'btn btn-success']); ?> &nbsp;
                </div>

            </div>
            <div class="portlet-body form">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="<?= $status==-2?'active':''; ?>"><a href="<?= \yii\helpers\Url::to(['/comic']); ?>">全部漫画</a></li>
                        <li class="<?= $status==Comic::STATUS_APPROVED?'active':''; ?>"><a href="<?= \yii\helpers\Url::to(['/comic','status'=>Comic::STATUS_APPROVED]); ?>">审核通过</a></li>
                        <li class="<?= $status==Comic::STATUS_CREATED?'active':''; ?>"><a href="<?= \yii\helpers\Url::to(['/comic','status'=>Comic::STATUS_CREATED]); ?>">待审核</a></li>
                        <li class="<?= $status==Comic::STATUS_REJECTED?'active':''; ?>"><a href="<?= \yii\helpers\Url::to(['/comic','status'=>Comic::STATUS_REJECTED]); ?>">审核失败</a></li>
                    </ul>
                    <div class="tab-content no-space">
                        <?php
                        //Pjax::begin(['id'=>'pjax-container']);
                        echo \yii\widgets\ListView::widget([
                            //'options' => ['class'=>'clearfix'],
                            'dataProvider' => $dataProvider,
                            'layout' => "{summary}\n<div class='items clearfix'>{items}</div>\n{pager}",
                            'itemOptions' => ['class' => 'list-item-subscribe col-xs-12 col-sm-3'],
                            'itemView' => 'list-item',
                        ]);
                        //Pjax::end();?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
$this->registerCssFile('@web/css/subscribe.css', ['position' => $this::POS_HEAD, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
?>