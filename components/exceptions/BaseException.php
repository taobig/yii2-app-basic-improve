<?php

namespace app\components\exceptions;

abstract class BaseException extends \Exception
{

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
        \QCustomLogger::log(\QCustomLogger::TYPE_ERROR, $message, $this->getTrace(), $this->getFile(), $this->getLine());
    }
}