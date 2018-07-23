<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 18-7-3
 * Time: 上午8:31
 */

namespace app\common\services;

//只用于加载应用本身的资源文件
class StaticService
{
    public static function includeAppJsStatic($path,$depend)
    {
        self::includeAppStatic("js", $path, $depend);
    }

    public static function includeAppCssStatic($path,$depend)
    {
        self::includeAppStatic("css", $path, $depend);
    }

    protected static function includeAppStatic($type,$path,$depend)
    {
        $release_version = defined("RELEASE_VERSION")?RELEASE_VERSION:time();
        $path = $path."?ver=".$release_version;
        if ($type == "css") {
            \Yii::$app->getView()->registerCssFile($path,["depends" => $depend]);
        } else {
            \Yii::$app->getView()->registerJsFile($path,["depends" => $depend]);
        }
    }

}