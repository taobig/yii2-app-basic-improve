<?php
namespace app\components;

use app\components\filters\VerbFilter;
use yii\web\Controller;
use yii\web\JsonParser;
use yii\web\Response;

class BaseApiController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    '*' => ['post'],
                ],
            ],
        ];
    }

    public function init()
    {
        \Yii::$app->request->enableCsrfValidation = false;
        \Yii::$app->request->parsers = [
            'application/json' => JsonParser::class,
        ];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

    public function beforeAction($action)
    {
        $params = \Yii::$app->request->getRawBody();
        \QCustomLogger::access($params, true);

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        if (!is_string($result)) {
            $message = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            $message = $result;
        }
        \QCustomLogger::access($message);

        return parent::afterAction($action, $result);
    }

    /**
     * @param array $data
     * @param string $message
     * @return array
     */
    public function successJsonResponse(array $data, string $message = '')
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return \QResponse::successJsonResponse($data, $message);
    }

    /**
     * @param string $message
     * @return array
     */
    public function errorJsonResponse(string $message)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return \QResponse::errorJsonResponse($message);
    }
}