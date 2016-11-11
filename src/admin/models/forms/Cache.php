<?php
namespace admin\models\forms;

use common\components\collect\Rule;
use common\models\collect\CollectList;
use common\models\user\User;
use yii\base\Model;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Cache form
 */
class Cache extends Model
{
    public $parts;
    public $all;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['all', 'parts'], 'safe'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'parts' => Yii::t('common', '清理内容'),
            'all' => Yii::t('common', '清理方式'),
        ];
    }
    public function load($data, $formName = null)
    {
        if(!parent::load($data, $formName)) return false;
        return true;
    }

}
