<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/19 13:09
 * @Description:
 */

namespace admin\models\system\configs;

use Yii;
use yii\base\Model;

/**
 * BaseForm
 */
class MallConfig extends Model
{
    public $mallName;
    public $siteUrl;
    public $siteTitle;
    public $siteSlogan;
    public $siteKeywords;
    public $siteDescription;
    public $adminEmail;
    public $adminQQ;
    public $icpSN;
    public $siteCopyright;
    public $headerCode;
    public $footerCode;
    public $socialCommentCode;
    public $socialShareCode;
    public $status=1;
    public $message;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'boolean'],
            ['adminEmail', 'email'],
            [['mallName', 'siteUrl', 'siteTitle', 'siteSlogan', 'siteKeywords', 'siteDescription', 'adminEmail', 'adminQQ', 'icpSN', 'siteCopyright','headerCode','footerCode','socialCommentCode','socialShareCode', 'message'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'mallName' => Yii::t('admin', 'Mall name'),
            'siteUrl' => Yii::t('admin', 'Site url'),
            'apiUrl' => Yii::t('admin', 'Api url'),
            'interfaceUrl' => Yii::t('admin', 'Interface url'),
            'siteTitle' => Yii::t('admin', 'Site title'),
            'siteSlogan' => Yii::t('admin', 'Site slogan'),
            'siteKeywords' => Yii::t('admin', 'Site keywords'),
            'siteDescription' => Yii::t('admin', 'Site description'),
            'adminEmail' => Yii::t('admin', 'Admin email'),
            'adminQQ' => Yii::t('admin', 'Admin QQ'),
            'icpSN' => Yii::t('admin', 'ICP SN'),
            'siteCopyright' => Yii::t('admin', 'Site copyright'),
            'headerCode' => Yii::t('admin', 'Header code'),
            'footerCode' => Yii::t('admin', 'Footer code'),
            'socialCommentCode' => Yii::t('admin', 'Social Comment code'),
            'socialShareCode' => Yii::t('admin', 'Social Share code'),
            'status' => Yii::t('admin', 'Site Status'),
            'message' => Yii::t('admin', 'Site closed display message'),
        ];
    }

}
