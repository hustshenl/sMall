<?php
$params = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'api\models\access\User',
            //'enableAutoLogin' => true,
            'enableSession' => false,
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
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['user/subscribe','history','comic'],
                    'pluralize' => false,
                    'patterns' => [
                        'OPTIONS' => 'options',
                        'POST {id}' => 'update',
                        'POST' => 'add',
                        'DELETE' => 'delete',
                    ]
                ],
            ],
            //'enableStrictParsing' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ]

    ],
    'modules' => [
        'treemanager' => [
            'class' => '\kartik\tree\Module',
        ]
    ],
    'params' => $params,
];
