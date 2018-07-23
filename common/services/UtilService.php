<?php
namespace app\common\services;

//封装通用方法
use yii\helpers\Html;

class UtilService
{
    public static function getIP(){
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    public static function encode($display)
    {
        return Html::encode($display);
    }

    public static function getRootPath()
    {
        return dirname(\Yii::$app->vendorPath);
    }
}