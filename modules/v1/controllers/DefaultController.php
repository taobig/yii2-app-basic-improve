<?php

namespace app\modules\v1\controllers;

use app\components\yii\BaseJsonController;
use app\components\yii\filters\VerbFilter;

class DefaultController extends BaseJsonController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ]);
    }

    /**
     * @link 'POST v1/default/index'
     */
    public function actionIndex()
    {
        return $this->successJsonResponse();
    }

}