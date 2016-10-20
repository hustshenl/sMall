<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2016/10/20
 * Time: 16:01
 */

namespace admin\widgets;


use yii\rbac\Rule;

class Test extends Rule
{
    public function execute($user, $item, $params){
        return true;
    }

}