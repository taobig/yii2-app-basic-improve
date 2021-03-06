<?php


// comment out the following four lines when deployed to production
//dev defined('YII_DEBUG') or define('YII_DEBUG', true);
//dev defined('YII_ENV') or define('YII_ENV', 'dev');

//test defined('YII_DEBUG') or define('YII_DEBUG', true);
//test defined('YII_ENV') or define('YII_ENV', 'test');

if (get_cfg_var("env.name")) {//dev or test
    switch (get_cfg_var("env.name")) {
        case 'dev':
        case 'test':
            define('YII_DEBUG', true);
            define('YII_ENV', get_cfg_var("env.name"));
            break;
    }
}


require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
