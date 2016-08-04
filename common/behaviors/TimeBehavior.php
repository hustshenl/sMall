<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/4/14 11:45
 * @Description:
 */

namespace common\behaviors;

use common\models\base\Tag;
use creocoder\flysystem\NullFilesystem;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;
use hustshenl\pinyin\Pinyin;
use yii;

class TimeBehavior extends AttributeBehavior
{
    public $timeAttributes = ['time'];
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->timeAttributes,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->timeAttributes,
            ];
        }
    }

    public function evaluateAttributes($event)
    {
        if (!empty($this->attributes[$event->name])) {
            $attributes = (array) $this->attributes[$event->name];
            //$value = $this->getValue($event);
            foreach ($attributes as $attribute) {
                // ignore attribute names which are not string (e.g. when set by TimestampBehavior::updatedAtAttribute)
                if (is_string($attribute)) {
                    $this->owner->$attribute = is_numeric($this->owner->$attribute)?$this->owner->$attribute:strtotime($this->owner->$attribute);
                }
            }
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
    public function touch($attribute)
    {
        $this->owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }
}