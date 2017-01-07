<?php

namespace app\modules\v1;

class V1 extends \yii\base\Module
{
    public $layout = false;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
