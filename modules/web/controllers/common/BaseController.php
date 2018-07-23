<?php
namespace app\modules\web\controllers\common;
use app\common\components\BaseWebController;
use app\common\services\AppLogService;
use app\common\services\UrlService;
use app\models\User;

//web统一控制器当中会做一些web独有的验证
//1:指定布局文件
//2:进行登录验证
class BaseController extends BaseWebController
{
    public $layout = "main";
    public $current_user = null;//当前登录人信息
    protected $auth_cookie_name = 'yiishop';
    public $allowAllAction = [
        "web/user/login"
    ];
    //登录统一验证
    public function beforeAction($action)
    {
        //验证是否登录
        $is_login = $this->checkLoginStatus();

        //避免登录页面重定向
        if(in_array($action->getUniqueId(),$this->allowAllAction)){
            return true;
        }

        if(!$is_login){
            if(\Yii::$app->request->isAjax){
                $this->renderJson([],"未登录，请先登录",-302);
            }else{
                $this->redirect(UrlService::buildWebUrl('/user/login'));
            }

            return false;
        }

        //记录所有用户的访问
        AppLogService::addAppAccessLog($this->current_user['uid']);
        return true;
    }

    //验证登录状态
    private function checkLoginStatus()
    {
        $auth_cookie = $this->getCookie($this->auth_cookie_name,'');
        if(!$auth_cookie){
            return false;
        }

        list($auth_token,$uid) = explode('#',$auth_cookie);
        if(!$auth_token || !$uid){
            return false;
        }

        if(!preg_match("/^\d+$/",$uid)){
            return false;
        }

        $user_info = User::find()->where(['uid'=>$uid])->one();
        if(!$user_info){
            return false;
        }

        if($auth_token != $this->geneAuthToken($user_info)){
            return false;
        }
        $this->current_user = $user_info;
        return true;
    }

    //设置登录
    public function setLoginStatus($user_info)
    {
        $auth_token = $this->geneAuthToken($user_info);
        $this->setCookie($this->auth_cookie_name,$auth_token.'#'.$user_info['uid']);
    }
    //清除登录状态
    public function removeLoginStatus()
    {
        $this->removeCookie($this->auth_cookie_name);
    }
    //统一生成加密字串
    public function geneAuthToken($user_info)
    {
        return md5($user_info['login_name'].$user_info['login_pwd'].$user_info['login_salt']);
    }
}