<?php

namespace app\modules\admin\controllers;

use app\components\BaseHtmlController;

class DefaultController extends BaseHtmlController
{

    public function actionIndex()
    {
        return $this->render("index");
    }

}