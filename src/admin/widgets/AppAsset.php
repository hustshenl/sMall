<?php

namespace admin\widgets;

use yii\web\AssetBundle;

/**
 * Main admin application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/app.css',
    ];
    public $js = [
        'js/app.js',
        //'js/dialog.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\widgets\PjaxAsset',
        'yii\bootstrap\BootstrapAsset',
        'dmstr\web\AdminLteAsset',
        'common\widgets\ToastrAsset'
    ];
}
