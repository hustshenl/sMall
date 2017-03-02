<?php
namespace seller\widgets;
use yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
/**
 * Class Menu
 * Theme menu widget.
 */
class Menu extends \dmstr\widgets\Menu
{

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
        if (isset($item['routes']) && is_array($item['routes']) && isset($item['routes'][0])) {
            foreach ($item['routes'] as $route) {
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
}
