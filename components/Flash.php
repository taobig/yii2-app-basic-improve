<?php

namespace app\components;


class Flash
{

    public static function setSuccess(string $success_message)
    {
        \Yii::$app->session->setFlash('success', $success_message);
    }

    public static function getSuccess(bool $delete = true):string
    {
        return \Yii::$app->session->getFlash('success', '', $delete);
    }

    public static function setDanger(string $danger_message)
    {
        \Yii::$app->session->setFlash('danger', $danger_message);
    }

    public static function getDanger(bool $delete = true):string
    {
        return \Yii::$app->session->getFlash('danger', '', $delete);
    }

}