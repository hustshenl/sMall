<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/7 16:54
 * @Description:
 */
use yii\helpers\Html;

/* @var $model member\models\comic\Comic */
?>
<div class="thumbnail">
    <?= Html::a(\Yii::$app->formatter->asImage($model->cover), $model->url); ?>
    <div class="caption">
        <h3><?= Html::a($model->title, $model->url); ?></h3>
        <p>最新章节：<span><?= $model->post_num>0?Html::a($model->last_chapter_name, $model->url.'/'.$model->last_chapter_id.'.html'):'暂无章节'; ?></span></p>
        <p>审核状态：<span><?= \Yii::$app->formatter->asLookup($model->status, 'approveStatus'); ?></span></p>
        <p>更新日期：<span><?= \Yii::$app->formatter->asDatetime($model->updated_at, 'php:Y-m-d'); ?></span></p>
        <p style="line-height: 2.5em;">
            <?= Html::a('章节列表', ['/chapter', 'comic_id' => $model->id], ['class' => 'btn btn-info btn-xs', 'role' => 'button']); ?>
            <?= Html::a('新增章节', ['/chapter/create', 'comic_id' => $model->id], ['class' => 'btn btn-primary btn-xs', 'role' => 'button']); ?>
            <?= Html::a('修改封面', ['/comic/update-cover', 'id' => $model->id], ['class' => 'btn btn-success btn-xs', 'role' => 'button']); ?>
            <?= Html::a('更新信息', ['/comic/update', 'id' => $model->id], ['class' => 'btn btn-danger btn-xs', 'role' => 'button']); ?>

            <?/*= Html::a('取消订阅', ['subscribe/cancel', 'id' => $model->id], ['class' => 'btn btn-default btn-xs', 'role' => 'button',
                'title' => \Yii::t('yii', 'Delete'),
                'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
            ]); */?>
        </p>
    </div>
</div>
