<?php

use yii\helpers\ArrayHelper;

require(__DIR__ . '/preload.php');

return [
    'id' => 'basic-console',
    'name' => CURRENT_PROJECT_NAME,
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'errorHandler' => [
            'class' => app\components\yii\handlers\ConsoleErrorHandler::class,
            //'errorAction' => 'site/error',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => \taobig\yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/app_console_u' . posix_getuid() . '.log',//运行console、web项目的用户可能不一样，避免权限问题，将日志文件分离
                ],
                [
                    'class' => \taobig\yii\log\FileTarget::class,
                    'levels' => ['trace', 'info',],
                    'logFile' => '@runtime/logs/info_console_u' . posix_getuid() . '.log',//运行console、web项目的用户可能不一样，避免权限问题，将日志文件分离
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
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];
