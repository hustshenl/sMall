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
        $permission = parent::getDirectPermissionsByUser($userId);
        if(isset(Yii::$app->params['super_admin'])&&in_array($userId,(array)Yii::$app->params['super_admin'])) {
            $row = [
                'type'=>yii\rbac\Item::TYPE_PERMISSION,
                'name' => 'super_admin',
                'description' => 'super_admin',
                'rule_name' => '',
                'data' => '',
                'created_at' => 0,
                'updated_at' => 0,
            ];
            $permission = array_merge($permission,['/*'=>$this->populateItem($row)]);
        }
        return $permission;
    }

}