<?php

namespace common\models\system;

use yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property string $conf_key
 * @property string $conf_value
 */
class Config extends yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conf_key', 'conf_value'], 'required'],
            [['conf_value'], 'string'],
            [['conf_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function submit($key,$value)
    {
        $config = static::findOne($key);
        if($config === false){
            $config = new static();
            $config->conf_key = $key;
        }

        $config->conf_value = json_encode($value,JSON_UNESCAPED_UNICODE);
        return $config->save();
    }

}
