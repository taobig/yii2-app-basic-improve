<?php

namespace app\components\yii;

class JsonResponseFactory
{

    /**
     * @param mixed $data
     * @param string $message
     * @return array
     */
    public static function buildSuccessJsonResponse($data, string $message = '')
    {
        return \QResponse::successJsonResponse($data, $message);
    }

    /**
     * @param string $message
     * @return array
     */
    public static function buildErrorJsonResponse(string $message)
    {
        return \QResponse::errorJsonResponse($message);
    }


}