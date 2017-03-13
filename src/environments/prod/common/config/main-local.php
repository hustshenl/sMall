<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'storage' => [
            'class' => 'weyii\filesystem\Manager',
            'default' => 'local',
            'disks' => [
                'local' => [
                    'class' => 'weyii\filesystem\adapters\Local',
                    'root' => '@resource/web' // 本地存储路径
                ],
                /*'qiniu' => [
                    'class' => 'weyii\filesystem\adapters\QiNiu',
                    'accessKey' => '七牛AccessKey',
                    'accessSecret' => '七牛accessSecret',
                    'bucket' => '七牛bucket空间',
                    'baseUrl' => '七牛基本访问地址, 如:http://72g7lu.com1.z0.glb.clouddn.com'
                ],
                'upyun' => [
                    'class' => 'weyii\filesystem\adapters\UpYun',
                    'operatorName' => '又拍云授权操作员账号',
                    'operatorPassword' => '又拍云授权操作员密码',
                    'bucket' => '又拍云的bucket空间',
                ],
                'aliyun' => [
                    'class' => 'weyii\filesystem\adapters\AliYun',
                    'accessKeyId' => '阿里云OSS AccessKeyID',
                    'accessKeySecret' => '阿里云OSS AccessKeySecret',
                    'bucket' => '阿里云的bucket空间',
                    // lanUrl和wanUrl样只需填写一个. 如果填写lanUrl 将优先使用lanUrl作为传输地址
                    // 外网和内网的使用参考: https://help.aliyun.com/document_detail/oss/user_guide/oss_concept/endpoint.html?spm=5176.2020520105.0.0.tpQOiL
                    'lanDomain' => 'OSS内网地址, 如:oss-cn-hangzhou-internal.aliyuncs.com', // 默认不填. 在生产环境下保证OSS和服务器同属一个区域机房部署即可, 切记不能带上bucket前缀
                    'wanDomain' => 'OSS外网地址, 如:oss-cn-hangzhou.aliyuncs.com' // 默认为杭州机房domain, 其他机房请自行替换, 切记不能带上bucket前缀
            ],*/
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
