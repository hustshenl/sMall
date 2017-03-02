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
        'identityClass' => 'common\models\access\User',
        'loginUrl' => '/account/login',
        'authTimeout' => 30*24*3600,
        //'enableSession' => false,
        'enableAutoLogin' => true,
    ],
    'authManager' => [
        'class' => 'seller\components\DbManager',
        //'class' => 'yii\rbac\DbManager',
    ],
    'errorHandler' => [
        'errorAction' => 'main/error',
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
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
            'admin*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@admin/messages',
                /*'fileMap' => [
                    'matrix' => 'app.php',
                ],*/
            ],
            'rbac*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@common/messages',
                'fileMap' => [
                    'rbac' => 'rbac.php',
                    'rbac-admin' => 'rbac.php',
                ],
            ],
        ],
    ],
    'image' => [
        'class' => 'yii\image\ImageDriver',
        'driver' => 'GD',  //GD or Imagick
    ],
    'request'=>[
        'enableCookieValidation'=>false,
    ]
];