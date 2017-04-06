<?php

namespace app\components\handlers;

use app\components\exceptions\BaseException;

class ConsoleErrorHandler extends \yii\base\ErrorHandler
{

    public function renderException($exception)
    {
        print_r($exception->__toString());
    }


    public function logException($exception)
    {
        if ($exception instanceof BaseException) {//will log by BaseException::__destruct()
            return;
        }
        \QCustomLogger::logException($exception);
    }

}
