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

class Configs extends \yii\base\Object
{
    const CACHE_KEY = 'hust.shenl.Config';

    public $configTableName = '{{%config}}';
    public $autoCreateConfigTable = false;
    public $strictMode = false;
    public $cacheDuration = 86400;
    private $_config;

    /*public function init()
    {
        if (isset(\Yii::$app->db->tablePrefix)) {
            $this->configTableName=\Yii::$app->db->tablePrefix.$this->configTableName;
        }
    }*/
    public function get($key)
    {
        $db = $this->_getDb();
        $cache = $this->_getCache();

        if (null === $this->_config)
        {
            $this->_getConfig($db, $cache);
        }

        if (false === is_array($this->_config) || false === array_key_exists($key, $this->_config))
        {
            if (true === $this->strictMode)
            {
                throw new Exception("Unable to get value - no entry present with key \"{$key}\".");
            }
            else
            {
                return null;
            }
        }

        return (null === $this->_config[$key]) ? null : unserialize($this->_config[$key]);

    }

    public function set($key, $value)
    {

        $db = $this->_getDb();
        $cache = $this->_getCache();

        if (null === $this->_config)
        {
            $this->_getConfig($db, $cache);
        }

        if (false === is_array($this->_config) || false === array_key_exists($key, $this->_config))
        {
            if (true === $this->strictMode)
            {
                throw new Exception("Unable to set value - no entry present with key \"{$key}\".");
            }
            else
            {
                $dbCommand = $db->createCommand("INSERT INTO {$this->configTableName} (`conf_key`, `conf_value`) VALUES (:key, :value)");
                $dbCommand->bindParam(':key', $key, \PDO::PARAM_STR);
                $dbCommand->bindValue(':value', serialize($value), \PDO::PARAM_STR);
                $dbCommand->execute();
            }
        }

        if (false === isset($dbCommand))
        {
            $dbCommand = $db->createCommand("UPDATE {$this->configTableName} SET `conf_value` = :value WHERE `conf_key` = :key LIMIT 1");
            $dbCommand->bindValue(':value', serialize($value), \PDO::PARAM_STR);
            $dbCommand->bindParam(':key', $key, \PDO::PARAM_STR);
            $dbCommand->execute();
        }

        $this->_config[$key] = serialize($value);

        if (false !== $cache)
        {
            $cache->set(self::CACHE_KEY, $this->_config, $this->cacheDuration);
        }

    }

    private function _getDb()
    {
        return Yii::$app->db;
    }

    private function _getCache()
    {
        return Yii::$app->cache;
    }

    private function _getConfig($db, $cache)
    {

        if (true === $this->autoCreateConfigTable)
        {
            $this->_createConfigTable($db);
        }

        if (false === $cache || false === ($this->_config = $cache->get(self::CACHE_KEY)))
        {
            $dbReader = $db->createCommand("SELECT * FROM {$this->configTableName}")->query();
            while (false !== ($row = $dbReader->read()))
            {
                $this->_config[$row['conf_key']] = $row['conf_value'];
            }
            if (false !== $cache)
            {
                $cache->set(self::CACHE_KEY, $this->_config, $this->cacheDuration);
            }
        }

    }

    private function _createConfigTable($db)
    {
        $db->createCommand("CREATE TABLE IF NOT EXISTS {$this->configTableName} (`conf_key` VARCHAR(100) PRIMARY KEY, `conf_value` TEXT) COLLATE = utf8_general_ci")->execute();
    }
}