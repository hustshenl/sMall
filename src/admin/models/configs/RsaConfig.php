<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/19 13:09
 * @Description:
 */

namespace admin\models\configs;

use Yii;
use yii\base\Model;

/**
 * BaseForm
 */
class RsaConfig extends Model
{
    public $privateKey;
    public $publicKey;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['privateKey', 'publicKey'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'privateKey' => Yii::t('admin', '私钥'),
            'publicKey' => Yii::t('admin', '公钥'),
        ];
    }

}
