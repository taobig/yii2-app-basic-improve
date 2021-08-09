<?php

use yii\helpers\ArrayHelper;

require(__DIR__ . '/preload.php');

$config = [
    'id' => 'basic',
    'name' => CURRENT_PROJECT_NAME,
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
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
            'identityClass' => app\components\yii\identity\EmployeeIdentity::class,
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'class' => app\components\yii\handlers\ErrorHandler::class,
        ],
        'urlManager' => [
//            'class' => yii\web\UrlManager::class,//is default
            'enablePrettyUrl' => true,//default is false
//            'suffix' => '.html', //This property is used only if [[enablePrettyUrl]] is true.
            'showScriptName' => false, //This property is used only if [[enablePrettyUrl]] is true.
            'rules' => [//the rules for creating and parsing URLs when [[enablePrettyUrl]] is true.
//                'GET /' => 'site/index',
//                'GET app/<id:\d+>' => 'app/get-by-id',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \taobig\yii\log\FileTarget::class,
                    'logVars' => [],
                    'levels' => ['error', 'warning'],//'error', 'warning', 'info', 'trace', 'profile'
                    'logFile' => '@runtime/logs/app_web_u' . posix_getuid() . '.log',
                ],
                [
                    'class' => \taobig\yii\log\FileTarget::class,
                    'categories' => ['access'],
                    'logVars' => [],
                    'levels' => ['info'],//'error', 'warning', 'info', 'trace', 'profile'
                    'logFile' => '@runtime/logs/access_web_u' . posix_getuid() . '.log',
                ],
                [
                    'class' => \taobig\yii\log\FileTarget::class,
                    'logVars' => ['_GET', '_POST', '_FILES', '_SESSION'],
                    'levels' => ['info',],
                    'logFile' => '@runtime/logs/info_web_u' . posix_getuid() . '.log',
                    'enabled' => YII_DEBUG ? true : false,
                ],
            ],
        ],
        'db' => require __DIR__ . '/db.php',
    ],
    'params' => ArrayHelper::merge(
        require(__DIR__ . '/params.php'),
        []
    ),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*', '*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            //'model' => taobig\yii\gii\model\Generator::class,
            'model' => [
                'class' => \yii\gii\generators\model\Generator::class,
                'baseClass' => \taobig\yii\model\BaseModel::class,
                'generateLabelsFromComments' => true,
                //'enableI18N' => true,
            ]
        ],
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*', '*'],
    ];
}

return $config;
