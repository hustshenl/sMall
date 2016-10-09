<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/10/8
 * Time: 13:04
 */
namespace common\widgets;



class AdvanceSearchAsset extends \kartik\base\AssetBundle
{
    public $sourcePath = '@common/assets';
    /**
     * @var array depended packages
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $js = [
        'js/advance-search.js',
    ];
    public $css = [
        'css/advance-search.css',
    ];
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
