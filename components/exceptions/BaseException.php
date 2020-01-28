<?php

namespace app\components\exceptions;

use Throwable;

abstract class BaseException extends \Exception
{

    protected $exposeErrorMessage = false;
    protected $extraData = null;

    public function getExposeErrorMessage(): bool
    {
        return $this->exposeErrorMessage;
    }

    public function getExtraData()
    {
        return $this->extraData;
    }

    public function __construct(string $message = "", int $code = null, Throwable $previous = null, $extraData = null)
    {
        $this->extraData = $extraData;

        parent::__construct($message, $code, $previous);
    }
}