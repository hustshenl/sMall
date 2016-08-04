<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/3/6 16:01
 * @Description:
 */

namespace member\widgets;

use member\components\AccessControl;

use yii;
use Yii\helpers\Url;
use Yii\helpers\ArrayHelper;
use yii\helpers\Html;

class HorizontalMenu extends \hustshenl\metronic\widgets\HorizontalMenu
{

    protected function normalizeItems($items, &$active, &$visible = true)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            $hasVisibleChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild, $hasVisibleChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['visible'])) {
                if(!$hasVisibleChild||$this->isItemVisible($item)){
                    $visible = $items[$i]['visible'] = true;
                }else{
                    unset($items[$i]);
                    continue;
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);

    }

    protected function isItemVisible($item)
    {

        //$childUrl = ArrayHelper::getValue($item, 'childUrl', '#');
        $actionUrl = ArrayHelper::getValue($item, 'url', '#');
        $actionId = Url::toRoute(/*$actionUrl == '#' ? $childUrl :*/ $actionUrl);
        $user = Yii::$app->user;
        if(in_array( $user->id,Yii::$app->params['super_member']))
        {
            return true;
        }
        if ($user->can('/' . ltrim($actionId, '/'))) {
            return true;
        }
        do {
            if ($user->can('/' . ltrim($actionId . '/*', '/'))) {
                return true;
            }
            $actionId = dirname($actionId);
        } while ($actionId!='/');
        return false;
    }

}