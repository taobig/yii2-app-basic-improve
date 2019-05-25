<?php

namespace app\components\yii\handlers;

use app\components\exceptions\BaseException;
use app\components\exceptions\UserException;
use app\components\yii\JsonResponseFactory;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class ErrorHandler extends \yii\web\ErrorHandler
{

    public function renderException($exception)
    {
        if (YII_ENV_DEV) {
            $errorMessage = $exception->__toString();
        } else {
            $errorMessage = '系统异常，请稍后重试 ' . date('Y-m-d');
            if ($exception instanceof UserException) {
                $errorMessage = $exception->getMessage();
            } else {//Framework Exception
                if ($exception instanceof NotFoundHttpException) {
                    $errorMessage = $exception->getMessage();//Page not found.
                }
            }
        }

        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            // reset parameters of response to avoid interference with partially created response data
            // in case the error occurred while sending the response.
            $response->isSent = false;
            $response->stream = null;
            $response->data = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        if (JsonResponseFactory::isJsonResponse() || $response->format == Response::FORMAT_JSON) {
            $response->setStatusCode(200);//保证返回格式为json时，HTTP状态码总是200
            if ($response->format != Response::FORMAT_JSON) {
                $response->format = Response::FORMAT_JSON;
            }

            if ($exception instanceof BaseException) {
                $response->data = JsonResponseFactory::buildErrorResponse($errorMessage, $exception->getCode());
            } else {
                $response->data = JsonResponseFactory::buildErrorResponse($errorMessage);
            }
        } else {
            $response->setStatusCodeByException($exception);
            $response->data = Yii::$app->view->render('@app/views/layouts/error', ['name' => '出错了……', 'message' => $errorMessage]);
        }
        $response->send();
    }


    public function logException($exception)
    {
        if ($exception instanceof BaseException) {//will log by BaseException::__destruct()
            return;
        }
        if ($exception instanceof NotFoundHttpException) {//don't log
            return;
        }
//        $category = get_class($exception);
//        if ($exception instanceof HttpException) {
//            $category = 'yii\\web\\HttpException:' . $exception->statusCode;
//        } elseif ($exception instanceof \ErrorException) {
//            $category .= ':' . $exception->getSeverity();
//        }
        \QCustomLogger::logException($exception);
    }

}
