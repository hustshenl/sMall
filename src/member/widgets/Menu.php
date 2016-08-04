<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace member\widgets;

use yii;
use Yii\helpers\Url;
use Yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Menu extends \hustshenl\metronic\widgets\Menu {

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @param integer $level the item level, starting with 1
     * @return string the rendering result
     */
/*    protected function renderItems($items, $level = 1)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item)
        {
            if(!$this->checkAccess($item))
            {
                continue;
            }
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active'])
            {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null)
            {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null)
            {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class))
            {
                if (empty($options['class']))
                {
                    $options['class'] = implode(' ', $class);
                }
                else
                {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            // set parent flag
            $item['level'] = $level;
            $menu = $this->renderItem($item);
            if (!empty($item['items']))
            {
                $menu .= strtr($this->submenuTemplate, [
                    '{items}' => $this->renderItems($item['items'], $level + 1),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }
        return implode("\n", $lines);
    }*/

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
/*    protected function renderItem($item)
    {
        if(!$this->checkAccess($item))
        {

            return '';
        }
        return parent::renderItem($item);
    }*/

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['childUrls']) && is_array($item['childUrls']) && isset($item['childUrls'][0])) {
            foreach ($item['childUrls'] as $childUrls) {
                $route = $childUrls;
                if ($route[0] !== '/' && Yii::$app->controller) {
                    $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
                }
                if (ltrim($route, '/') === $this->route) {
                    return true;
                }
            }
        }
        return parent::isItemActive($item);
    }
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
                if($hasVisibleChild||$this->isItemVisible($item)){
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
        return true;

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
