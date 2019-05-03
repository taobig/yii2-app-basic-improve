<?php

namespace app\components\yii\filters;

use app\components\exceptions\UserException;
use Yii;
use yii\base\ActionEvent;

class VerbFilter extends \yii\filters\VerbFilter
{

    /**
     * @param ActionEvent $event
     * @return boolean
     * @throws UserException when the request method is not allowed.
     */
    public function beforeAction($event)
    {
        $action = $event->action->id;
        if (isset($this->actions[$action])) {
            $verbs = $this->actions[$action];
        } elseif (isset($this->actions['*'])) {
            $verbs = $this->actions['*'];
        } else {
            return $event->isValid;
        }

        $verb = Yii::$app->getRequest()->getMethod();
        $allowed = array_map('strtoupper', $verbs);
        if (!in_array($verb, $allowed)) {
            $event->isValid = false;
            // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7
            Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', $allowed));
            //throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: ' . implode(', ', $allowed) . '.');
            throw new UserException('Method Not Allowed. This url can only handle the following request methods: ' . implode(', ', $allowed) . '.');
        }

        return $event->isValid;
    }
}
