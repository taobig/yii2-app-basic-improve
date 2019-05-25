<?php

namespace app\components\yii;

use yii\web\Controller;
use yii\web\Response;

abstract class BaseController extends Controller
{

    /**
     * @param array|object|null $data
     * @param string $message
     * @return array
     */
    public function successJsonResponse($data = null, string $message = '')
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_object($data) && !is_array($data) && !is_null($data)) {
            throw new \TypeError('type error');
        }
        return JsonResponseFactory::buildSuccessResponse($data, $message);
    }

    /**
     * @param string $message
     * @return array
     */
    public function errorJsonResponse(string $message)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return JsonResponseFactory::buildErrorResponse($message);
    }
}