<?php

namespace app\components\yii;

use yii\web\Response;

class JsonResponse
{

    /**
     * @param array|object|null $data
     * @param string $message
     * @return array
     */
    public static function successJsonResponse($data, string $message = '')
    {
        if (!is_object($data) && !is_array($data) && !is_null($data)) {
            throw new \TypeError('type error');
        }
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return \QResponse::successJsonResponse($data, $message);
    }

    /**
     * @param string $message
     * @return array
     */
    public static function errorJsonResponse(string $message)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return \QResponse::errorJsonResponse($message);
    }


}