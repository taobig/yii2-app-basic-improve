<?php
namespace app\components\yii;

use yii\web\Controller;

abstract class BaseController extends Controller
{


    /**
     * @param array $data
     * @param string $message
     * @return array
     */
    public function successJsonResponse(array $data, string $message = '')
    {
        return JsonResponse::successJsonResponse($data, $message);
    }

    /**
     * @param string $message
     * @return array
     */
    public function errorJsonResponse(string $message)
    {
        return JsonResponse::errorJsonResponse($message);
    }
}