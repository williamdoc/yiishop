<?php
namespace app\modules\web\controllers;
use app\common\services\UrlService;
use app\models\User;
use app\modules\web\controllers\common\BaseController;

class UserController extends BaseController
{
    public $layout = "main";

    public function actionLogin()
    {
        //如果是get则展示登录页面,如果是post则业务处理
        if(\Yii::$app->request->isGet){
            $this->layout = false;
            return $this->render('login');
        }
        //登录逻辑处理
        $login_name = trim($this->post('login_name',''));
        $login_pwd = trim($this->post('login_pwd',''));

        if(!$login_name || !$login_pwd){
            return $this->renderJs('请输入正确的用户名或密码',UrlService::buildWebUrl('/user/login'));
        }

        //验证用户名
        $user_info = User::find()->where(['login_name'=>$login_name])->one();
        if(!$user_info){
            return $this->renderJs('请输入正确的用户名',UrlService::buildWebUrl('/user/login'));
        }
        //验证用户密码
        //密码加密算法: md5(login_pwd+md5(login_salt))
        if(!$user_info->verifyPassword($login_pwd)){
            return $this->renderJs('密码错误',UrlService::buildWebUrl('/user/login'));
        }
        //保存用户登录状态
        //TODO:用cookie保存  用session保存
        //加密字符串+"#"+uid,加密字符串=md5(login_name+login_pwd+login_salt)
        $this->setLoginStatus($user_info);
        return $this->redirect(UrlService::buildWebUrl('/dashboard/index'));

    }

    public function actionEdit()
    {
        if (\Yii::$app->request->isGet) {
            return $this->render('edit',['user_info'=>$this->current_user]);
        }

        $nickname = trim($this->post("nickname",""));
        $email = trim($this->post("email",""));

        if (mb_strlen($nickname,"utf-8") < 1) {
            return $this->renderJson([],"请输入合法的姓名",-1);
        }

        if (mb_strlen($email,"utf-8") < 1) {
            return $this->renderJson([],"请输入合法的邮箱地址",-1);
        }

        $user_info = $this->current_user;
        $user_info->nickname = $nickname;
        $user_info->email = $email;
        $user_info->update_time = date("Y-m-d H:i:s");
        $user_info->update(0);

        return $this->renderJson([], "编辑成功");


    }

    public function actionResetPwd()
    {
        if (\Yii::$app->request->isGet) {
            return $this->render('reset_pwd',['user_info' => $this->current_user]);
        }

        $old_password = trim($this->post("old_password",""));
        $new_password = trim($this->post("new_password",""));

        if (mb_strlen($old_password,'utf-8') < 1) {
            return $this->renderJson([],'请输入原密码');
        }

        if (mb_strlen($new_password,'utf-8') < 6) {
            return $this->renderJson([],'请输入合法的新密码');
        }

        if ($old_password == $new_password) {
            return $this->renderJson([],'新密码不能与旧密码一样');
        }
        //判断原密码是否正确
        $user_info = $this->current_user;
        if (!$user_info->verifyPassword($old_password)){
            return $this->renderJson([],'原密码错误',-1);
        }

        //更新密码
        $user_info->setPassword($new_password);
        $user_info->update_time = date('Y-m-d H:i:s');
        $user_info->update(0);

        $this->setLoginStatus($user_info);
        return $this->renderJson([],'密码重置成功');


    }

    public function actionLogout()
    {
        $this->removeLoginStatus();
        return $this->redirect(UrlService::buildWebUrl('/user/login'));
    }

}