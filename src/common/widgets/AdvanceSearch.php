<?php

/**
 * @copyright Copyright (c) 2012 - 2015 SHENL.COM
 * @license http://www.shenl.com/license/
 */

namespace common\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;

class AdvanceSearch extends ActiveForm
{
    public $trigger;
    /**
     * Initializes the widget.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        // TODO 写入Form前
        //echo 'begin';
        echo '<div id="advance-search-panel">';
        $this->type = static::TYPE_VERTICAL;
        //$this->options = ArrayHelper::merge($this->options,['class'=>'advance-search-panel']);
        $this->formConfig =  [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showErrors' => true,
            //'showLabels' => false,
        ];
        parent::init();
        $this->registerAssets();
    }

    public function run()
    {
        parent::run();
        // TODO: 写入Form后
        //echo 'end';
        echo '</div>';
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        AdvanceSearchAsset::register($view);
        // TODO 配合高级搜索
        if($this->trigger){
            $id = 'jQuery("' . $this->trigger . '")';
            $view->registerJs('var $advanceSearchTrigger='.$id.';if($advanceSearchTrigger.length){yii.advanceSearch.trigger("'.$this->trigger.'");}');
        }else{
            throw new InvalidConfigException('必须设置AdvanceSearch类的trigger属性！');
        }
    }
}