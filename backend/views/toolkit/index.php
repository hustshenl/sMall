<?php
use yii\helpers\Html;
use hustshenl\metronic\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('admin', '个人资料');
$this->params['subTitle'] = $this->title;
$this->params['breadcrumbs']['links'] = [
    $this->params['subTitle']
];
?>


<div class="row shop-apply">
    <div class="col-md-12">
        <div class="portlet ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i><span
                        class="caption-subject bold uppercase"><?= $this->params['subTitle'] ?></span>
                </div>
                <div class="actions">
                </div>

            </div>
            <div class="portlet-body form">

                <!--搜索-->
                <!--<div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info">第<b>1-1</b>条，共<b>2</b>条数据.</div></div></div>-->
                <div class="table-container">

                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th width="100">{label}</th><td>{value}</td></tr>',
                        'attributes' => [
                            'username',
                            [
                                'attribute' => 'status',
                                'label' => '状态',
                                'format' => 'raw',
                                'value' => Yii::$app->formatter->asLookUp($model->status,'userStatus')
                            ],
                            'phone',
                            'email',
                            [
                                'label' => '最后登陆时间',
                                'format' => ['datetime','php: Y-m-d H:i:s'],
                                'value' => $model->updated_at,
                            ],
                            [
                                'label' => '最后登陆IP',
                                //'format' => ['datetime','php: Y-m-d H:i:s'],
                                'value' => long2ip($model->login_ip)/*.Yii::$app->request->getUserIP()*/,
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

