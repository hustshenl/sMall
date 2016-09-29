<?php

/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version   3.0.1
 */

namespace common\widgets;

use yii\web\View;

/**
 * Asset bundle for GridView CheckboxColumn
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ActionColumnAsset extends \kartik\base\AssetBundle
{
    public $sourcePath = '@common/assets';
    /**
     * @var array depended packages
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\widgets\ToastrAsset',
    ];
    public $js = [
        'js/action-column.js',
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
