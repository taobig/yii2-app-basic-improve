<?php

const STATIC_RESOURCE_HOST = '';// "http://localhost/"
const STATIC_RESOURCE_VERSION = 2018001;

require(__DIR__ . '/preload.php');

$config = [
    'id' => 'basic',
    'name' => CURRENT_PROJECT_NAME,
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => app\modules\admin\Admin::class,
            'layout' => 'main',
        ],
        'v1' => [
            'class' => app\modules\v1\V1::class,
        ],
    ],
    'components' => [
//        'mailer' => [
//            'class' => yii\swiftmailer\Mailer::class,
////            'useFileTransport' => true,
//            'transport' => [
//                'class' => Swift_SmtpTransport::class,
//                'host' => '',
//                'username' => '',
//                'password' => '',
////                'port' => '587',
////                'encryption' => 'tls',
//            ],
//        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
        'user' => [
            'identityClass' => app\models\UserIdentity::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'class' => app\components\handlers\ErrorHandler::class,
        ],
        'urlManager' => [
//            'class' => 'yii\web\UrlManager',//is default
            'enablePrettyUrl' => true,//default is false
//            'suffix' => '.html', //This property is used only if [[enablePrettyUrl]] is true.
            'showScriptName' => false, //This property is used only if [[enablePrettyUrl]] is true.
            'rules' => [//the rules for creating and parsing URLs when [[enablePrettyUrl]] is true.
//                'class' => 'yii\web\UrlRule',//is default
//                'GET /' => 'site/index',
//                'GET app/<id:\d+>' => 'app/get-by-id',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => yii\log\FileTarget::class,
                    'logVars' => ['_GET', '_POST', '_FILES', '_SESSION'],
                    'levels' => ['info',],
                    'logFile' => '@runtime/logs/info.log',
                    'enabled' => YII_DEBUG ? true : false,
                ],
            ],
        ],
        'db' => require __DIR__ . '/db.php',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*'],
    ];
}

return $config;
