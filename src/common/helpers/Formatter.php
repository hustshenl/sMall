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

    /**
     * 将GB/MB等数值转化为字节数
     * @param $value
     * @return int
     */
    public function asSizeValue($value)
    {

        if ($value === null) {
            return $this->nullDisplay;
        }
        $res = 0;
        $bytes = [
            'p'=>1024*1024*1024*1024*1024, // P
            't'=>1024*1024*1024*1024, // T
            'g'=>1024*1024*1024, // G
            'm'=>1024*1024,// M
            'k'=>1024,//K
            'b'=>1,
        ];
        preg_match('/(\d{0,10}\.{0,1}\d{0,10})\s{0,3}(b|k|m|g|t|p){0,1}/i',(string)$value,$matches);
        if(isset($matches[1])){
            $unit = isset($matches[2])?strtolower($matches[2]):'b';
            $res = isset($bytes[$unit])?floatval($matches[1])*$bytes[$unit]:0;
        }
        return intval($res);
    }

    /*public function asRelativeTime($value, $referenceTime = null)
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
    }*/
    public function asDurationValue($value)
    {

        if ($value === null) {
            return $this->nullDisplay;
        }
        $res = 0;
        $seconds = [
            1=>365*24*3600,
            2=>30*24*3600,
            3=>7*24*3600,
            4=>24*3600,
            5=>3600,
            6=>60,
            7=>1,
        ];
        preg_match('/(?:(\d+)?[^\d]{0,3}(?:年|year|y))?[^\d]{0,3}(?:(\d+)?[^\d]{0,3}(?:月|month|m))?[^\d]{0,3}(?:(\d+)?[^\d]{0,3}(?:周|星期|week|w))?[^\d]{0,3}(?:(\d+)?[^\d]{0,3}(?:日|天|day|d))?[^\d]{0,3}(?:(\d+)?[^\d]{0,3}(?:小时|时|hour|h))?[^\d]{0,3}(?:(\d+)?[^\d]{0,3}(?:分钟|分|minute|i))?[^\d]{0,3}(?:(\d+)?[^\d]{0,3}(?:秒钟|秒|second|s))?/i',$value,$matches);
        foreach ($matches as $key =>$match){
            if(empty($matches)) continue;
            if(isset($seconds[$key])) $res+=$seconds[$key]*intval($match);
        }
        return $res;
    }

    /**
     * 将秒数格式化为绝对的期间值，1年365天，1月30天
     * @param $value
     * @return string
     */
    public function asAbsoluteDuration($value)
    {

        if ($value === null) {
            return $this->nullDisplay;
        }
        $res = 'P';
        $designators = ['Y','M','D'];
        $mods = [365*24*3600,30*24*3600,7*24*3600];
        foreach ($designators as $key => $designator){
            $mod = $mods[$key];
            $num = intval(floor($value/$mod));
            if($num>0) $res .= $num.$designator;
            $value %= $mod;
        }
        if($res == 'P') $res=0;
        return parent::asDuration($res);
    }

    public function asPrice($value, $decimals = 2, $unit = '元', $currency='',$dec_point = '.', $thousands_sep = '')
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        return $currency.number_format($value / 1000, $decimals, $dec_point, $thousands_sep) . $unit;
    }
    public function asPriceValue($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        preg_match('/([,\d]+)(\.\d{0,3})?/i',$value,$matches);
        if(!isset($matches[0])) return 'empty';
        $value = str_replace(',','',$matches[0]);
        return intval(floatval($value)*1000) ;
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