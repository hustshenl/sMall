<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/7 11:28
 * @Description:
 */

namespace member\widgets;
use yii\helpers\Html;

class Badge extends \hustshenl\metronic\widgets\Badge
{
    public $options = [];
    public function run()
    {
        $options = $this->options;
        Html::addCssClass($options, 'badge');
        if (!$this->round) {
            Html::addCssClass($options, 'badge-roundless');
        }
        Html::addCssClass($options, 'badge-' . $this->type);

        echo Html::tag('span', $this->label, $options);
    }
}