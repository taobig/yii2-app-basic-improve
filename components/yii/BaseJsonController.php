<?php
namespace app\components\yii;

use app\components\yii\filters\VerbFilter;
use taobig\yii\log\CustomLogger;
use yii\web\JsonParser;
use yii\web\Response;

class BaseJsonController extends BaseController
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
        CustomLogger::access('access', $params, true);

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        if (!is_string($result)) {
            $message = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            $message = $result;
        }
        CustomLogger::access('access', $message);

        return parent::afterAction($action, $result);
    }

}