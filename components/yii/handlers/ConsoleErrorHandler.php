<?php

namespace app\components\yii\handlers;

use app\components\exceptions\BaseException;

class ConsoleErrorHandler extends \yii\base\ErrorHandler
{

    public function renderException($exception)
    {
        print_r($exception->__toString());
    }


    public function logException($exception)
    {
        \Yii::error($exception);
    }

}
