<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/3/24 14:15
 * @Description:
 */

namespace common\helpers;


class Formatter extends \yii\i18n\Formatter
{
    private static $_items = [];

    public function asImage($value, $options = [])
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        if (empty($value)) {
            if (isset($options['default'])) {
                $value = \Yii::$app->params['domain']['resource'] . $options['default'];
                unset($options['default']);
            } else {
                $value = \Yii::$app->params['domain']['resource'] . \Yii::$app->params['image']['default']['common'];
            }
        }
        if (!preg_match('/\b(([\w-]+:\/\/?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/)))/i', $value)) {
            $value = \Yii::$app->params['domain']['resource'] . $value;
        }
        return parent::asImage($value, $options);
    }

    public function asDate($value, $format = null)
    {
        if ($value == 0) return '-';
        return parent::asDate($value, $format);
    }

    public function asDuration($value, $implodeString = ', ', $negativeSign = '-')
    {
        $minute = round((time() - $value) / 60);
        if ($minute < 60) {
            $res = ($minute ? $minute : 1) . '分钟前';
        } else if ($minute < (60 * 24)) {
            $res = round($minute / 60) . '小时前';
        } else {
            $res = round($minute / (60 * 24)) . '天前';
        }
        return $res;
    }

    public function asPrice($value, $decimals = 2, $unit = '元', $dec_point = '.', $thousands_sep = '')
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        return number_format($value / 100, $decimals, $dec_point, $thousands_sep) . $unit;
    }

    public function asLookup($value, $type)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        if (is_array($type)) return isset($type[$value]) ? $type[$value] : $this->nullDisplay;
        if (empty(self::$_items)) self::loadItems();
        if (!isset(self::$_items[$type])) return false;
        return isset(self::$_items[$type][$value]) ? self::$_items[$type][$value] : false;
    }


    protected static function loadItems()
    {
        self::$_items = \Yii::$app->params['lookup'];
    }
}