<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/3/13 13:39
 * @Description:
 */

//基本状态
$items = [
    'status' => ['禁用', '启用'],
    'charset' => ['UFT-8', 'GBK'],
    'approveStatus' => ['待审核', '已通过', '已经拒绝'],//审核状态
    'commendStatus' => ['未推荐', '已推荐'],
    'originalStatus' => ['非原创', '原创'],
    'vipStatus' => ['VIP', '非VIP'],
    'handleStatus' => ['待处理', '已处理', '处理中'],//处理状态handle

    'tagCategory' => [1 => '主题', 2 => '标签'],
    'replyStatus' => ['未回复', '已回复'],//回复状态
    'role' => ['系统', '用户', '管理员'],//用户角色
    'userStatus' => [1 => '正常', 0 => '屏蔽'],
    'gender' => ['通用', '男', '女'],
    'genderSlug' => ['gender', 'male', 'female'],
    'genderStatus' => ['保密', '男', '女'],
    'boolean' => [1 => '是', 0 => '否'],
];
return $items;
