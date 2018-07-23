<?php
namespace app\common\services;


class UploadService extends BaseService
{
    //根据文件路径进行上传
    public static function uploadByFile($file_name,$file_path,$bucket='')
    {
        if (!$file_name) {
            return self::_err("文件名是必须的");
        }

        if (!$file_path || !file_exists($file_path)) {
            return self::_err("请输入合法的文件路径");
        }

        $upload_config = \Yii::$app->params['upload'];
        if (!isset($upload_config[$bucket])) {
            return self::_err("指定参数bucket错误");
        }

        $tmp_file_extend = explode('.',$file_name);
        $file_type = strtolower(end($tmp_file_extend));
        $hash_key = md5(file_get_contents($file_path));
        //在每个bucket下，按照日期存放图片
        $upload_dir_path = UtilService::getRootPath()."/web".$upload_config[$bucket]."/";
        $folder_name = date("Ymd");

        $upload_dir = $upload_dir_path.$folder_name;
        //print_r($upload_dir);exit;
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir,0777);
            chmod($upload_dir,0777);
        }

        $upload_full_name = $folder_name."/".$hash_key.".{$file_type}";
        if (is_uploaded_file($file_path)) {//判断文件是否是通过 HTTP POST 上传的
            move_uploaded_file()

        }
    }

}