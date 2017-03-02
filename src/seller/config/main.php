<?php
$params = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$components = require(__DIR__ . '/components.php');
return [
    'id' => 'app-seller',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'seller\controllers',
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
    ],
    'as access' => [
        'class' => 'seller\components\AccessControl',
        'allowActions' => [
            'account/login', 'account/forget', 'account/logout', 'main/error',
            'join/*','javascript/*','sso/sign','sso/exit'
        ]
    ],
];
