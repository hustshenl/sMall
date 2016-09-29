<?php
/**
 * @copyright Copyright (c) 2012 - 2015 SHENL.COM
 * @license http://www.shenl.com/license/
 */

namespace  common\widgets;

use yii\web\AssetBundle;

/**
 * SpinnerAsset for spinner widget.
 */
class ToastrAsset extends AssetBundle
{
    public $sourcePath = '@bower/toastr';
    public $js = [
        'toastr.min.js',
    ];

    public $css = [
        'toastr.min.css',
    ];

    public $depends = [];
}
