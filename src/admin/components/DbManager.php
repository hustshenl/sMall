<?php
/**
 * Author: Shen.L
 * Date: 2016/7/11
 * Time: 10:36
 */

namespace admin\components;

use yii;

class DbManager extends \mdm\admin\components\DbManager
{

    public function getPermissionsByUser($userId)
    {
        /** 添加最高权限用户权限检测，之前修改原因遗忘，若有问题，请在此基础上进行修改 */
        if(isset(Yii::$app->params['super_admin'])&&in_array($userId,(array)Yii::$app->params['super_admin'])) {
            $permission = parent::getDirectPermissionsByUser($userId);
            $row = [
                'type'=>yii\rbac\Item::TYPE_PERMISSION,
                'name' => 'super_admin',
                'description' => 'super_admin',
                'rule_name' => '',
                'data' => '',
                'created_at' => 0,
                'updated_at' => 0,
            ];
            return array_merge($permission,['/*'=>$this->populateItem($row)]);
        }else{
            return parent::getPermissionsByUser($userId);
        }
    }

}