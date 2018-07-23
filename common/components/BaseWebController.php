<?php
namespace app\common\components;
use yii\web\Controller;
use yii\web\Cookie;

/*
 * 常用公用方法
 * get,post,setCookie,getCookie,removeCookie,renderJson
 */
class BaseWebController extends Controller
{
    public $enableCsrfValidation = false;//关闭csrf

    //获取http的get参数
    public function get($key,$default_val=""){
        return \Yii::$app->request->get($key,$default_val);
    }

    //获取http的post参数
    public function post($key,$default_val=""){
        return \Yii::$app->request->post($key,$default_val);
    }

    //设置cookie值
    public function setCookie($name,$value,$expire = 0){
        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => $name,
            'value' => $value,
            'expire' => $expire
        ]));
    }

    //获取cookie
    public function getCookie($name,$default_val=''){
        $cookies = \Yii::$app->request->cookies;
        return $cookies->getValue($name,$default_val);
    }

    //删除cookie
    public function removeCookie($name){
        $cookies = \Yii::$app->response->cookies;
        $cookies->remove($name);
    }

    //api统一返回json格式方法
    public function renderJson($data = [],$msg='ok',$code = 200){
        header("Content-type: application/json");
        echo json_encode([
            "code" => $code,
            "msg" => $msg,
            "data" => $data,
            "req_id" => uniqid()//序列号，根据序列号可以反推出来什么时候调用的什么方法调用的
        ]);

    }

    //统一js提醒
    public function renderJs($message,$url)
    {
        return $this->renderPartial('@app/views/common/js',['msg'=>$message,'url'=>$url]);
    }
}