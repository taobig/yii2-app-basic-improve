<?php

namespace app\modules\admin\controllers;

use app\components\yii\BaseHtmlController;

class DefaultController extends BaseHtmlController
{

    public function actionIndex()
    {
        return $this->render("index");
    }

}