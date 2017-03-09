<?php
$lookup = require(__DIR__ . '/lookup.php');

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'upload' => [
        'maxSize' => 1024,//单位K
        'cover' => [
            'path' => 'images/cover/',//封面保存路径
            'crop' => true,
            'width' => 240,
            'height' => 320,
            'quality' => 60,
        ],
        'avatar' => [
            'path' => 'images/author/',//封面保存路径
            'crop' => true,
            'width' => 320,
            'height' => 320,
            'quality' => 60,
        ],
        'block' => [
            'path' => 'images/block/',//封面模块路径
        ],
        'temp' => [
            'saveOriginal' => true,
            'path' => 'images/temp/',//临时目录
        ],
    ],
    'image' => [
        'default' => [
            'common' => 'images/default/common.png',
            'cover' => 'images/default/cover.png',
            'avatar' => 'images/default/avatar.png',
        ],
    ],
    'pagination' => [
        'defaultPageSize' => 20,
    ],
    'lookup' => $lookup,
];
