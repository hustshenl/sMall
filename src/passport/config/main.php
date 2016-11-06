<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-passport',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'passport\controllers',
    'defaultRoute' => 'passport',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\access\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/login',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'passport/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix' => '/',
            'rules' => [
                'login'=>'passport/login',
                'logout'=>'passport/logout',
                'register'=>'passport/register',
            ],
        ],
    ],
    'params' => $params,
];
