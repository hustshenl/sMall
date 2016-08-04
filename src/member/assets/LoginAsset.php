<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/7 11:14
 * @Description:
 */

namespace member\assets;


use yii\web\AssetBundle;

class LoginAsset extends AssetBundle {

    /**
     * @var string source assets path
     */
    public $sourcePath = '@hustshenl/metronic/assets';

    /**
     * @var array depended packages
     */
    public $depends = [
        'hustshenl\metronic\bundles\CoreAsset',
    ];

    /**
     * @var array css assets
     */
    public $css = [
        'admin/pages/css/login-4.css',
        'global/plugins/uniform/themes/default/css/uniform.default.css',
    ];

    /**
     * @var array js assets
     */
    public $js = [
        //'global/plugins/jquery-validation/dist/jquery.validate.min.js',
        'global/plugins/backstretch/jquery.backstretch.min.js',
        'global/plugins/jquery-validation/dist/jquery.validate.min.js',
        'global/plugins/jquery-validation/dist/additional-methods.min.js',
        'global/plugins/jquery-validation/dist/additional-methods.min.js',
        'global/plugins/uniform/jquery.uniform.min.js',
        'admin/pages/scripts/login-4.js',
    ];


}