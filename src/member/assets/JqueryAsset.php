<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\web;

use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class JqueryAsset extends AssetBundle
{
    public $js = [
        'jquery.js',
        //'http://apps.bdimg.com/libs/jquery/1.11.3/jquery.min.js',
    ];

    /**
     * Inits bundle
     */
    public function init()
    {
        $this->_handleStyleBased();

        return parent::init();
    }

    /**
     * Handles style based files
     */
    private function _handleStyleBased()
    {
        //$this->css = ArrayHelper::merge($this->styleBasedCss[Metronic::getComponent()->style], $this->css);
    }


    /**
     * @var array js options
     */
    public $jsOptions = [
        'conditions' => [
            //'http://apps.bdimg.com/libs/jquery/1.11.3/jquery.min.js' => 'if lt IE 9',
        ],
    ];

}
