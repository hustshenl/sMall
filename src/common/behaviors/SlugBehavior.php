<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/4/14 11:45
 * @Description:
 */

namespace common\behaviors;

use creocoder\flysystem\NullFilesystem;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;
use hustshenl\pinyin\Pinyin;
use yii;
use yii\validators\UniqueValidator;

class SlugBehavior extends yii\behaviors\SluggableBehavior
{
    public $slugAttribute = 'slug';
    public $value;
    public $attribute = 'name';
    public $uniqueValidator = [];
    public $ensureUnique = true;

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        $attributes = (array)$this->attribute;
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        $isNewSlug = false;
        foreach ($attributes as $attribute) {
            if ($owner->isAttributeChanged($attribute)) {
                $isNewSlug = true;
                break;
            }
        }
        if ($isNewSlug||empty($owner->{$this->slugAttribute})) {
            $slugParts = [];
            foreach ($attributes as $attribute) {
                $slugParts[] = $owner->{$attribute};
            }
            $slug = Pinyin::trans(implode('-',$slugParts),['only_word'=>true]);
        } else {
            $slug = $owner->{$this->slugAttribute};
        }
        if(empty($slug)) $slug = 'unknown';
        if ($this->ensureUnique) {
            $baseSlug = $slug;
            $iteration = 0;
            while (!$this->validateSlug($slug)) {
                $iteration++;
                $slug = $this->generateUniqueSlug($baseSlug, $iteration);
            }
        }
        return $slug;
    }

    protected function validateSlug($slug)
    {
        /* @var $validator UniqueValidator */
        /* @var $model BaseActiveRecord */
        $validator = Yii::createObject(array_merge(
            [
                'class' => yii\validators\UniqueValidator::className()
            ],
            $this->uniqueValidator
        ));

        $model = clone $this->owner;
        $model->clearErrors();
        $model->{$this->slugAttribute} = $slug;

        $validator->validateAttribute($model, $this->slugAttribute);
        return !$model->hasErrors();
    }

    protected function generateUniqueSlug($baseSlug, $iteration)
    {
        if (is_callable($this->uniqueSlugGenerator)) {
            return call_user_func($this->uniqueSlugGenerator, $baseSlug, $iteration, $this->owner);
        } else {
            return $baseSlug . '' . ($iteration + 1);
        }
    }


    public function touchSlug($attribute)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        $owner->updateAttributes(array_fill_keys((array)$attribute, $this->getValue(null)));
    }
}