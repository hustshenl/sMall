<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\base;

use yii;
use yii\base\Arrayable;
use yii\base\Component;
use yii\base\Model;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Link;
use yii\web\Request;
use yii\web\Response;

/**
 * Class Serializer
 * @package api\components
 * @property string $scenario
 */

class Serializer extends \yii\rest\Serializer
{
    public $customer=[];
    private $_scenario = false;

    public function setScenario($scenario){
        $this->_scenario = $scenario;
    }
    public function getScenario(){
        if(!$this->_scenario) $this->_scenario = Model::SCENARIO_DEFAULT;
        return $this->_scenario;
    }
    public function serialize($data)
    {
        $data = parent::serialize($data);
        //var_dump($data);
        if ($this->customer !== false) {
            //return $data;
            return array_merge($data, $this->customer);
        } else {
            return $data;
        }
        //return $data;
    }

    protected function serializeModel($model)
    {
        $model = parent::serializeModel($model);
        if ($this->collectionEnvelope === null) {
            return $model;
        } else {
            return [
                $this->collectionEnvelope => $model,
            ];
        }
    }

    /*    protected function serializeDataProvider($dataProvider)
        {
            $result = parent::serializeDataProvider($dataProvider);
            if ($pagination !== false) {
                return array_merge($result, $this->serializePagination($pagination));
            } else {
                return $result;
            }
        }*/


    /**
     * Serializes a set of models.
     * @param array $models
     * @return array the array representation of the models
     */
    protected function serializeModels(array $models)
    {
        list ($fields, $expand) = $this->getRequestedFields();
        foreach ($models as $i => $model) {
            if ($model instanceof Arrayable) {
                /**
                 * @var $model Model
                 */
                $model->scenario = $this->scenario;
                $models[$i] = $model->toArray($fields, $expand);
            } elseif (is_array($model)) {
                $models[$i] = ArrayHelper::toArray($model);
            }
        }

        return $models;
    }

}
