<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace member\components;

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

class Serializer extends \yii\rest\Serializer
{
    public $customer=[];

    public function serialize($data)
    {
        $data = parent::serialize($data);
        if ($this->customer !== false) {
            return array_merge($data, $this->customer);
        } else {
            return $data;
        }
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

}
