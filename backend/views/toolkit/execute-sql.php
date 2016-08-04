<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/17 17:37
 * @Description:
 */
use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use hustshenl\metronic\widgets\ActiveForm;

$this->title = \Yii::t('backend', 'Execute Sql');;
$this->params['subTitle'] = \Yii::t('backend', 'Execute Sql');
$this->params['breadcrumbs'] = [
    $this->params['subTitle']
];

?>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <!--<i class="icon-settings"></i>--><?/*= $this->params['subTitle'] */?>
                    </div>
                    <div class="actions btn-set">

                    </div>

                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form id="w2" class="form-horizontal" method="post">
                        <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->getCsrfToken() ?>">
                        <div class="form-body">
                            <div class="form-group field-adminform-username">
                                <label class="col-md-3 control-label" for="adminform-username">在此输入SQL语句</label>
                                <div class="col-md-4">
                                    <textarea name="sql" id="" cols="30" rows="5" class="form-control" placeholder="在此输入SQL语句"></textarea>
                                    <div class="help-block"></div>
                                </div>
                            </div>

                        </div><div class="form-actions fluid"><div class="col-md-offset-3 -3"><button type="submit" id="w0" class="btn btn-primary btn-default">执行SQL</button>
                                <button type="button" id="w1" class="btn default control-back btn-default">取消</button></div></div></form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>

