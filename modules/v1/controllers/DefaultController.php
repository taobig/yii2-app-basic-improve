<?php

namespace app\modules\v1\controllers;

use app\components\yii\BaseJsonController;

class DefaultController extends BaseJsonController
{

    /**
     * @link 'POST v1/default/all'
     */
    public function actionAll()
    {
        return $this->successJsonResponse([]);
    }

}