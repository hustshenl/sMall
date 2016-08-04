<?php


use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use kartik\detail\DetailView;


/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \member\models\forms\LoginForm */

$this->title = $model->username;
$this->params['subTitle'] = $this->title;
/*$this->params['breadcrumbs']['links'] = [
    $this->params['subTitle']
];*/
?>


<div class="row shop-apply">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <?= Yii::$app->formatter->asImage(\Yii::$app->user->identity->avatarUrl,['class'=>'img-circle','style'=>'width:5em;border: 1px solid #ccc;']); ?>
                </div>
                <div class="caption" style="padding:2em 1em 0;">
                    <p><span class="caption-subject bold"><?= $this->params['subTitle'] ?></span>
                    <span class="caption-subject">(UID:<?= $model->id ?>)</span></p>
                    <p><span class="caption-subject"><?= $model->email ?></span></p>
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
                        'attributes' => [
                            [
                                'group'=>true,
                                'label'=> '基本信息',
                                'rowOptions'=>['class'=>'info']
                            ],
                            [
                                'attribute'=>'nickname',
                                'displayOnly'=>true
                            ],
                            [
                                'attribute'=>'gender',
                                'format'=>['lookup','genderStatus'],
                                'displayOnly'=>true
                            ],
                            [
                                'attribute'=>'status',
                                'format'=>'raw',
                                'value'=> $model->status?
                                    '<span class="label label-success">正常</span>'
                                    :'<span class="label label-danger">禁止访问</span>',
                                'displayOnly'=>true
                            ],

                            [
                                'attribute'=>'phone',
                                'displayOnly'=>true
                            ],
                            [
                                'attribute'=>'qq',
                                'displayOnly'=>true
                            ],
                            [
                                'attribute'=>'weibo',
                                'displayOnly'=>true
                            ],

                            [
                                'attribute'=>'address',
                                'format'=>'raw',
                                'value'=> $model->province.$model->city.$model->district.$model->address.($model->postcode?'('.$model->postcode.')':''),
                            ],
                            [
                                'attribute'=>'signature',
                            ],
                            [
                                'group'=>true,
                                'label'=> '统计信息',
                                'rowOptions'=>['class'=>'info']
                            ],
                            [
                                'attribute'=>'scores',
                            ],
                            [
                                'label' => '最后登陆时间',
                                'format' => ['datetime','php: Y-m-d H:i:s'],
                                'value' => $model->login_at,
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

