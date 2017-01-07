<?php

namespace app\modules\v1\controllers;

use app\components\BaseApiController;

class TestController extends BaseApiController
{

    /**
     * @link 'POST v1/test/all'
     */
    public function actionAll()
    {
        return $this->successJsonResponse([]);
    }

}