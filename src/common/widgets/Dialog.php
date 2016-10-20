<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/10/18
 * Time: 23:46
 */

namespace common\widgets;


use yii\helpers\Html;
use yii\helpers\Url;

class Dialog extends \kartik\dialog\Dialog {
    private static $_initiated = false;
    public static function alert($text, $options = [],$config=[])
    {
        static::widget($config);
        $options =static::formatOptions($options,'alert');
        return Html::tag('dlg',$text,$options);
    }
    public static function confirm($text, $options = [],$config=[])
    {
        static::widget($config);
        $options =static::formatOptions($options,'confirm');
        return Html::tag('dlg',$text,$options);
    }
    public static function prompt($text, $options = [],$config=[])
    {
        static::widget($config);
        $options =static::formatOptions($options,'prompt');
        return Html::tag('dlg',$text,$options);
    }

    public static function widget($config = [])
    {
        if(!static::$_initiated){
            static::$_initiated = true;
            DialogAsset::register(\Yii::$app->getView());
            return \kartik\dialog\Dialog::widget($config);
        }
        return '';
    }

    public function registerAssets()
    {
        $view = $this->getView();
    }
    protected static function formatOptions(&$options,$mode=false)
    {
        if(isset($options['data-href'])&&is_array($options['data-href'])){
            $options['data-href'] = Url::to($options['data-href']);
        }
        if($mode){
            $options['data-mode'] = $mode;
        }
        if(!isset($options['id'])) $options['id'] = static::genId();
        return $options;
    }
    protected static function genId()
    {
        return static::$autoIdPrefix . static::$counter++;
    }
}