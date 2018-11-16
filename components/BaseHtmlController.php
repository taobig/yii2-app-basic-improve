<?php
namespace app\components;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class BaseHtmlController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                //'only' => ['logout'],
                'rules' => [
                    [
                        //'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}