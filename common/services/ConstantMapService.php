<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 18-7-5
 * Time: 上午7:56
 */

namespace app\common\services;


class ConstantMapService
{
    public static $status_default = -1;
    public static $status_mapping = [
        1 => '正常',
        0 => '已删除'
    ];

    public static $default_avater = "default_avater";
    public static $default_password = "******";
}