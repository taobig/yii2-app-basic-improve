<?php

require(__DIR__ . '/preload.php');

$config = [
    'id' => 'basic-console',
    'name' => CURRENT_PROJECT_NAME,
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'errorHandler' => [
            'class' => app\components\handlers\ConsoleErrorHandler::class,
            //'errorAction' => 'site/error',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
//                [
//                    'class' => yii\log\FileTarget::class,
//                    'levels' => ['trace', 'info',],
//                    'logFile' => '@runtime/logs/console_trace.log',
//                ],
            ],
        ],
        'db' => require __DIR__ . '/db.php',
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

return $config;
