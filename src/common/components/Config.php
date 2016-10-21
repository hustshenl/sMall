<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/5/13 9:56
 * @Description:
 */

namespace common\components;

use yii;
use yii\db\Connection;
use yii\caching\Cache;
use yii\helpers\ArrayHelper;
use common\models\system\Config as ConfigModel;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * Class Configs
 * @package common\components
 */
class Config extends yii\base\Object
{
    const CACHE_KEY = 'hust.shenl.small.Config';

    public $strictMode = false;
    public $cacheDuration = 86400;
    private $_config;

    public function init()
    {
        parent::init();
    }

    /**
     * @param $category
     * @param string $key
     * @return mixed|null
     * @throws Exception
     */
    public function get($category, $key = null)
    {
        if (null === $this->_config) {
            $this->_getConfig();
        }
        if (is_array($this->_config)) {
            $value = ArrayHelper::getValue($this->_config, $category, false);
            $value = false === $value || null === $value ? null : json_decode($value, true);
            if (null === $key) return $value;
            return null === $value ? null : ArrayHelper::getValue($value, $key, null);
        }
        if (true === $this->strictMode) {
            throw new Exception("Unable to get value - no entry present with key \"{$category}\".");
        } else {
            return null;
        }
    }

    /**
     * @param string $category
     * @param array $value
     * @return bool
     */
    public function set($category, $value)
    {
        if (null === $this->_config) {
            $this->_getConfig();
        }
        if (!ConfigModel::submit($category, $value)) {
            return false;
        }
        $this->_config[$category] = json_encode($value, JSON_UNESCAPED_UNICODE);
        return Yii::$app->cache->set(self::CACHE_KEY, $this->_config, $this->cacheDuration);
    }

    public function cleanCache()
    {
        Yii::$app->cache->delete(static::CACHE_KEY) && $this->_config = null;
    }

    private function _getConfig()
    {
        if (false === ($this->_config = Yii::$app->cache->get(self::CACHE_KEY))) {
            $items = ConfigModel::find()->all();
            $this->_config = array_column($items, 'conf_value', 'conf_key');
            Yii::$app->cache->set(self::CACHE_KEY, $this->_config, $this->cacheDuration);
        }
    }

    /*private function _createConfigTable($db)
    {
        $db->createCommand("CREATE TABLE IF NOT EXISTS {$this->configTableName} (`conf_key` VARCHAR(255) PRIMARY KEY, `conf_value` TEXT) COLLATE = utf8_general_ci")->execute();
    }*/
}