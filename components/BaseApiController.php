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
                'class' => VerbFilter::className(),
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
        $userIp = \Yii::$app->request->userIP;
        $log = "\n[{$userIp}][" . \Yii::$app->request->getMethod() . '][' . $action->getUniqueId() . "]\n";
        $params = \Yii::$app->request->getRawBody();
        if (!empty($params)) {
            $log .= $params;
        }
        \QCustomLogger::access($log . "\n");

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        \QCustomLogger::access($result);

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