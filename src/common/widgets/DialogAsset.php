<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/10/18
 * Time: 23:46
 */


namespace common\widgets;

use yii\web\View;

class DialogAsset extends \kartik\base\AssetBundle
{
    public $sourcePath = '@common/assets';
    /**
     * @var array depended packages
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'kartik\dialog\DialogAsset',
    ];
    public $js = [
        'js/dialog.js',
    ];
    public $css = [
        //'css/dialog.css',
    ];
    /**
     * @inheritdoc
     */
    public function init()
    {
        //$this->setupAssets('js', ['js/kv-grid-checkbox']);
        parent::init();
    }
}