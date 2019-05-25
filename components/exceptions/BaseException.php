<?php

namespace app\components\exceptions;

use app\components\yii\JsonResponseFactory;
use Throwable;

abstract class BaseException extends \Exception
{

    public function __construct($message = "", $code = JsonResponseFactory::CODE_COMMON_ERROR, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __destruct()
    {
        $message = $this->getMessage();
        if ($this instanceof APIException) {
            $message .= ' ' . $this->getUrl() . ' ' . json_encode($this->getRequest());
            $response = $this->getResponse();
            if (!is_string($response)) {
                $message .= ' ' . json_encode($response);
            } else {
                $message .= ' ' . $response;
            }
        }
        \QCustomLogger::logException($this, $message);
    }
}