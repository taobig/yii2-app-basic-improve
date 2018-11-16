<?php

namespace app\components;


use yii\web\Response;

class JsonResponse
{

    /**
     * @param array $data
     * @param string $message
     * @return array
     */
    public static function successJsonResponse(array $data, string $message = '')
    {
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