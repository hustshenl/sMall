<?php
/**
 * @Author shen@shenl.com
 * @Create Time: 2015/2/12 16:43
 * @Description:
 */


return [
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'user' => [
        'identityClass' => 'member\models\access\User',
        'loginUrl' => '/account/login',
        'authTimeout' => 30*24*3600,
        //'enableSession' => false,
        //'loginUrl' => '/site/login',
        'enableAutoLogin' => true,
    ],
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules'=>[
            'login'=>'account/login',
            'logout'=>'account/logout',
            'register'=>'account/register',
            'home'=>'account/home',
        ],
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning','info'],
                'logFile' => '@runtime/logs/http-request.log',
                'categories' => ['yii\httpclient\*'],
            ],
        ],
    ],

    'i18n' => [
        'translations' => [
            'member*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@member/messages',
            ],
        ],
    ],

    'metronic' => [
        'class' => 'hustshenl\metronic\Metronic',
        //'color' => 'default',
        'theme' => 'light',
        'layoutOption' => \hustshenl\metronic\Metronic::LAYOUT_FLUID,
        'sidebarOption' => \hustshenl\metronic\Metronic::SIDEBAR_FIXED,
        'headerOption' => 'fixed',
        'headerDropdown' => 'light',
    ],
    'image' => [
        'class' => 'yii\image\ImageDriver',
        'driver' => 'GD',  //GD or Imagick
    ]
];