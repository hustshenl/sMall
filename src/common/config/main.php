<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    //'timeZone'=>'Asia/shanghai',
    'components' => [
        'formatter' => [
            'class' => 'common\helpers\Formatter',
        ],
        'i18n' => [
            'translations' => [
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'common' => 'app.php',
                        'common/error' => 'error.php',
                    ],
                ],
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'config' => [
            'class' => 'common\components\system\Config',
        ],
        /*
            'fs' => [
                'class' => 'creocoder\flysystem\LocalFilesystem',
                'path' => '@resource/web',
            ],*/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix' => '/',
        ],
    ],
];
