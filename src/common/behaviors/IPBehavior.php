<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/4/14 11:45
 * @Description:
 */

namespace common\behaviors;

use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;
use yii;

class IPBehavior extends AttributeBehavior
{
    public $loginAttribute = 'login_ip';
    public $registerAttribute = 'register_ip';
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->registerAttribute, $this->loginAttribute],
                //BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->loginAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return $this->value !== null ? call_user_func($this->value, $event) : ip2long(Yii::$app->request->getUserIP());
        }
    }

    /**
     * Updates a timestamp attribute to the current timestamp.
     *
     * ```php
     * $model->touch('lastVisit');
     * ```
     * @param string $attribute the name of the attribute to update.
     */
    public function touchIp($attribute='login_ip')
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if ($owner->getIsNewRecord()) {
            throw new InvalidCallException('Updating the timestamp is not possible on a new record.');
        }
        $owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }

}