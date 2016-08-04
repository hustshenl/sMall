<?php

use yii\helpers\Html;
use hustshenl\metronic\widgets\Button;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use common\components\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\comic\Chapter */
/* @var $form yii\widgets\ActiveForm */
$this->registerCss('.kv-upload-progress .progress {height: 18px;}');
$this->registerJsFile("@web/js/chapter/form.js", ['position' => $this::POS_END, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
$this->registerAssetBundle(\yii\jui\JuiAsset::className());
$this->registerJs('ChapterForm.initEvents();');
$dir = Upload::generateTempDir();
$basename = basename($dir);
?>
<div class="chapter-form">
    <div class="form-body">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'id' => 'chapter-form'],
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'formConfig' => ['labelSpan' => 4, 'deviceSize' => ActiveForm::SIZE_LARGE]
        ]);
        $url = \yii\helpers\Url::to(['author/ajax-list', 'data-label' => 'results']);
        /*echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'chapter_detail' => [   // complex nesting of attributes along with labelSpan and colspan
                    'label'=>'章节信息',
                    'labelSpan'=>1,
                    'columns'=>6,
                    'attributes'=>[
                        'name'=>[
                            'type'=>Form::INPUT_TEXT,
                            'options'=>['placeholder'=>'输入章节名称'],
                            'columnOptions'=>['colspan'=>2],
                        ],
                        'sort'=>[
                            'type'=>Form::INPUT_TEXT,
                            'options'=>['placeholder'=>'排序值']
                        ],
                    ]
                ],
            ]
        ]);*/
        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 3,
            'attributes' => [
                'name' => ['options' => ['placeholder' => '章节名称']],
                //'sort' => ['options' => ['placeholder' => '排序值']],
                /* 'rtl' => [
                     'type' => Form::INPUT_RADIO_BUTTON_GROUP,
                     'items' => Yii::$app->params['lookup']['boolean'],
                     'options' => [
                         'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]
                     ]
                 ],*/
                'image_mode' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '双页',
                            'offText' => '单页',
                        ],
                    ]
                ],
                'rtl' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '从右到左',
                            'offText' => '从左到右',
                        ],
                    ]
                ],
                'category' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data' => $categories,
                        'options' => ['placeholder' => '选择或者输入章节类型 ...', 'multiple' => false],
                        'pluginOptions' => [
                            'tags' => true,
                            'maximumInputLength' => 10
                        ],
                    ]
                ],
                'sort' => [
                    //'label'=>false,
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\TouchSpin',
                    'options' => [
                        'pluginOptions' => [
                            'buttonup_class' => 'btn btn-primary',
                            'buttondown_class' => 'btn btn-info',
                            'step' => 1,
                            'max' => 999999999,
                            'min' => -999999999
                        ],
                    ]
                ],
                'is_vip' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '是',
                            'offText' => '否',
                        ],
                    ]
                ],
            ]
        ]);
        ?>
        <div class="row">
            <div class="col-lg-4">
                <?php
                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'is_end' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\SwitchInput',
                            'options' => [
                                'containerOptions' => ['class' => ''],
                                'pluginOptions' => [
                                    'onText' => '是',
                                    'offText' => '否',
                                ],
                            ]
                        ],
                    ]
                ]);

                ?>
            </div>
            <div class="col-lg-8">
                <?php
                echo Form::widget([ // continuation fields to row above without labels
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'options' => ['id' => 'end-warp'],
                    'attributes' => [
                        /*'is_end' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\SwitchInput',
                            'options' => [
                                'containerOptions' => ['class' => ''],
                                'pluginOptions' => [
                                    'onText' => '是',
                                    'offText' => '否',
                                ],
                            ]
                        ],*/
                        'nextChapter' => ['options' => ['placeholder' => '下一章名称']],
                        'nextPost' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\DatePicker',
                            'format' => 'datetime',
                            'options' => [
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                ],
                            ]
                        ],

                        /*'is_end' => [
                            'type' => Form::INPUT_RADIO_BUTTON_GROUP,
                            'items' => Yii::$app->params['lookup']['boolean'],
                            'options' => [
                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]
                            ]
                        ],*/
                    ]
                ]);

                ?>
            </div>
        </div>
        <?php
        /*echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 3,
            'attributes' => [
                'is_end' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '是',
                            'offText' => '否',
                        ],
                    ]
                ],
                'is_vip' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\SwitchInput',
                    'options' => [
                        'containerOptions' => ['class' => ''],
                        'pluginOptions' => [
                            'onText' => '是',
                            'offText' => '否',
                        ],
                    ]
                ],
            ]
        ]);*/
        ?>

        <?php
        echo Html::hiddenInput('temp_path', $basename);
        echo Html::hiddenInput('remove_images', '');
        echo Html::hiddenInput('move_images', '');
        echo Html::hiddenInput('images', '');
        echo Html::hiddenInput('isCreateComic', isset($isCreateComic));
        echo '<fieldset id="upload-file">';
        /*echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributeDefaults'=>[
                'type'=>Form::INPUT_TEXT,
                'labelOptions'=>['class'=>'col-md-3'],
                'inputContainer'=>['class'=>'col-md-9'],
                'container'=>['class'=>'form-group1'],
            ],
            'attributes' => [

                'file' => [
                    'label'=> false,
                    'inputContainer' => ['class'=>'col-md-12'],
                    'container'=>['class'=>'form-group'],
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\FileInput',
                    'options' => [
                    'options' => [
                        'multiple' => true,
                        'id' => 'input-file',
                    ],
                    'pluginOptions' => [
                        'initialPreview' => $model->preview['preview'],
                        'initialPreviewConfig' => $model->preview['config'],
                        'deleteUrl' => \yii\helpers\Url::to(['/chapter/file-upload']),
                        'deleteExtraData' => ['id' => 101],
                        'allowedFileTypes' => ['image'],
                        'overwriteInitial' => false,
                        'browseClass' => 'btn btn-primary',
                        'uploadClass' => 'btn btn-success',
                        'removeClass' => 'btn btn-danger',
                        'uploadUrl' => \yii\helpers\Url::to(['/chapter/file-upload']),
                        'uploadExtraData' => [
                            'basename' => $basename,
                        ],
                        'maxFileCount' => 200
                    ]
                ]],
            ]
        ]);*/

        echo FileInput::widget([
            'model' => $model,
            'attribute' => 'file',
            'options' => [
                'multiple' => true,
                //'id' => 'input-file',
            ],
            'pluginOptions' => [
                'initialPreview' => $model->preview['preview'],
                'initialPreviewConfig' => $model->preview['config'],
                'deleteUrl' => \yii\helpers\Url::to(['/chapter/file-upload']),
                'deleteExtraData' => ['id' => 101],
                'allowedFileTypes' => ['image'],
                'overwriteInitial' => false,
                'browseClass' => 'btn btn-primary',
                'uploadClass' => 'btn btn-success',
                'removeClass' => 'btn btn-danger',
                'uploadUrl' => \yii\helpers\Url::to(['/chapter/file-upload']),
                'uploadExtraData' => [
                    'basename' => $basename,
                    //'cat_id' => 'Nature'
                ],
                /*'previewSettings' => [
                    'image' => ['width' => 'auto', 'height' => '160px'],
                    'object' => ['width' => 'auto', 'height' => '160px'],
                    'html' => ['width' => 'auto', 'height' => '160px'],
                    'text' => ['width' => 'auto', 'height' => '160px'],
                    'other' => ['width' => 'auto', 'height' => '160px'],
                ],*/
                'maxFileCount' => 200
            ]
        ]);
        echo '</fieldset>';

        //echo $form->field($model, 'name')->hiddenInput();

        echo Form::widget([ // continuation fields to row above without labels
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'actions' => [
                    'type' => Form::INPUT_RAW,
                    'value' => '<div style="text-align: center; margin-top: 20px">' .
                        Button::widget(['label' => $model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), 'options' => ['type' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]) .
                        Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn default']) . ' ' .
                        '</div>'
                ],
            ]
        ]);
        ActiveForm::end();
        ?>
    </div>
</div>
<?php
$this->registerJs('ChapterForm.init();');
?>
