<?php

namespace app\modules\v1\controllers;

use app\components\BaseApiController;

class DefaultController extends BaseApiController
{

    /**
     * @link 'POST v1/default/all'
     */
    public function actionAll()
    {
        return $this->successJsonResponse([]);
    }

}