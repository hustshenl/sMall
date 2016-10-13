<?php
$params = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$components = require(__DIR__ . '/components.php');
return [
    'id' => 'app-admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'defaultRoute' => 'main',
    'bootstrap' => ['log'],
    'components' => $components,
    'params' => $params,
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'access' => [
            'class' => 'mdm\admin\Module',
            'defaultUrlLabel' => 'Access',
            'viewPath'=>'@admin/views/access',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'admin\controllers\access\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'searchClass' => 'admin\models\access\AdminSearch'
                ],
            ],
        ]
    ],
    'as access' => [
        'class' => 'admin\components\AccessControl',
        'allowActions' => [
            'account/login', 'account/forget', 'account/logout', 'main/error',
        ]
    ],
];
