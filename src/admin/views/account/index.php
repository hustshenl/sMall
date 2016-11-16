<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use kartik\detail\DetailView;


/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \admin\models\forms\LoginForm */

$this->title = Yii::t('admin', '个人资料');
$this->params['subTitle'] = Yii::$app->user->identity->username;
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['/account']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>


<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="box-title caption">
                    <i class="fa fa-user"></i> <span
                        class="caption-subject bold uppercase"><?= $this->params['subTitle'] ?></span>
                </div>
                <div class="actions">
                </div>

            </div>
            <div class="box-body">

                <!--搜索-->
                <!--<div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info">第<b>1-1</b>条，共<b>2</b>条数据.</div></div></div>-->
                <div class="table-container">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'username',
                            'nickname',
                            [
                                'attribute' => 'status',
                                'label' => '状态',
                                'format' => 'raw',
                                'value' => Yii::$app->formatter->asLookUp($model->status,'userStatus')
                            ],
                            'phone',
                            'email',
                            /*[
                                'label' => '最后登陆时间',
                                'format' => ['datetime','php: Y-m-d H:i:s'],
                                'value' => $model->login_at,
                            ],
                            [
                                'label' => '最后登陆IP',
                                //'format' => ['datetime','php: Y-m-d H:i:s'],
                                'value' => long2ip($model->login_ip)
                            ],*/
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

