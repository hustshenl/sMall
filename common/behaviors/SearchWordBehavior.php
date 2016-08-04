<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/4/14 11:45
 * @Description:
 */

namespace common\behaviors;

use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;
use hustshenl\pinyin\Pinyin;
use yii;

class SearchWordBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive the SearchWord value
     */
    public $searchWordAttribute = 'search_word';
    /**
     * @var string|array the attribute or list of attributes whose value will be converted into a slug
     */
    public $attribute = 'name';
    public $value;
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [BaseActiveRecord::EVENT_BEFORE_VALIDATE => $this->searchWordAttribute];
        }

        if ($this->attribute === null && $this->value === null) {
            throw new InvalidConfigException('Either "attribute" or "value" property must be specified.');
        }
    }
    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        $attributes = (array)$this->attribute;
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        $isNewSearchWord = false;
        foreach ($attributes as $attribute) {
            if ($owner->isAttributeChanged($attribute)) {
                $isNewSearchWord = true;
                break;
            }
        }
        if ($isNewSearchWord) {
            $searchWordParts = [];
            foreach ($attributes as $attribute) {
                $searchWordParts[] = $owner->{$attribute};
            }
            $searchWord =  implode(' ',$searchWordParts);
            $searchWord .= Pinyin::trans($searchWord);
        } else {
            $searchWord = $owner->{$this->searchWordAttribute};
        }
        return $searchWord;
    }


    public function touch($attribute)
    {
        $this->owner->updateAttributes(array_fill_keys((array)$attribute, $this->getValue(null)));
    }
}