<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/7 16:54
 * @Description:
 */
use yii\helpers\Html;

/* @var $model member\models\member\Subscribe */
?>
<div class="thumbnail">
    <?= Html::a(\Yii::$app->formatter->asImage($model->comic->cover), $model->comic->url); ?>
    <div class="caption">
        <h3><?= Html::a($model->comic->title, $model->comic->url); ?></h3>
        <p>更新内容：<span><?= Html::a($model->update_chapter, $model->getUpdateUrl(true)); ?></span></p>
        <p>更新时间：<span><?= \Yii::$app->formatter->asDatetime($model->update_at, 'php:Y-m-d'); ?></span></p>
        <p>
            <?= Html::a('继续阅读', $model->comic->url, ['class' => 'btn btn-primary btn-xs', 'role' => 'button']); ?>
            <?= Html::a('删除记录', ['history/delete', 'id' => $model->id], ['class' => 'btn btn-default btn-xs', 'role' => 'button',
                'title' => \Yii::t('yii', 'Delete'),
                'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
            ]); ?>
        </p>
    </div>
</div>
