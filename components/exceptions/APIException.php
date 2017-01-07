<?php

namespace app\components\exceptions;


class APIException extends UserException
{

    private $_url;
    private $_response;
    private $_request;

    public function getUrl(): string
    {
        return $this->_url;
    }

    /**
     * @return array|string
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return array|string
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * APIException constructor.
     * @param string $message
     * @param string $url
     * @param array|string $response
     * @param array|string $request
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(string $message, string $url, $response, $request, int $code = 0, \Exception $previous = null)
    {
        $this->_url = $url;
        $this->_response = $response;
        $this->_request = $request;

        parent::__construct($message, $code, $previous);
    }
}