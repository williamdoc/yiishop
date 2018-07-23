<?php
namespace app\modules\web\controllers;
use app\common\services\AppLogService;
use app\common\services\ConstantMapService;
use app\common\services\UrlService;
use app\models\log\AppAccessLog;
use app\models\User;
use app\modules\web\controllers\common\BaseController;

class AccountController extends BaseController
{
    public function actionIndex()
    {
        $status = intval($this->get('status',ConstantMapService::$status_default));
        $mix_kw = trim($this->get("mix_kw", ""));
        $p = intval($this->get("p",1));

        $query = User::find();
        if ($status > ConstantMapService::$status_default) {
            $query->andWhere(['status'=>$status]);
        }

        if ($mix_kw) {
            $where_nickname = ['LIKE','nickname','%'.$mix_kw.'%',false];//默认为true，自动加首尾的%
            $where_mobile = ['LIKE','mobile','%'.$mix_kw.'%',false];
            $query->andWhere(['OR',$where_nickname,$where_mobile]);
        }

        //分页功能，需要两个参数，1：符合条件的记录总数2：每页显示条数
        $page_size = 5;
        $total_res_count = $query->count();
        $total_page = ceil($total_res_count/$page_size);//ceil向上取整

        $list = $query->orderBy(['uid'=>SORT_DESC])
            ->offset(($p-1)*$page_size)
            ->limit($page_size)
            ->all();
        return $this->render('index',[
            'list' => $list,
            'status_mapping' => ConstantMapService::$status_mapping,
            'search_conditions' => [
                'mix_kw' => $mix_kw,
                'status' => $status,
                'p' => $p
            ],
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $page_size,
                'total_page' => $total_page,
                'p' => $p
            ]
        ]);
    }

    public function actionSet()
    {
        if (\Yii::$app->request->isGet) {
            $id = intval($this->get("id",0));
            $user_info = [];
            if ($id) {
                $user_info = User::find()->where(["uid" => $id])->one();
            }
            return $this->render('set',[
                'user_info' => $user_info
            ]);
        }

        $nickname = trim($this->post("nickname",""));
        $mobile = trim($this->post("mobile",""));
        $email = trim($this->post("email",""));
        $login_name = trim($this->post("login_name",""));
        $login_pwd = trim($this->post("login_pwd",""));
        $date_now = date("Y-m-d H:i:s");
        $id = intval($this->post("id",""));
        if (mb_strlen($nickname, 'utf-8') < 1) {
            return $this->renderJson([],"请输入合法的用户名",-1);
        }
        if (mb_strlen($mobile, 'utf-8') < 1) {
            return $this->renderJson([],"请输入合法的手机号码",-1);
        }
        if (mb_strlen($email, 'utf-8') < 1) {
            return $this->renderJson([],"请输入合法的电子邮箱地址",-1);
        }
        if (mb_strlen($login_name, 'utf-8') < 1) {
            return $this->renderJson([],"请输入合法的登录名",-1);
        }
        if (mb_strlen($login_pwd, 'utf-8') < 1) {
            return $this->renderJson([],"请输入合法的登录密码",-1);
        }

        $has_in = User::find()->where(['login_name'=>$login_name])->andWhere(['!=','uid',$id])->count();
        if ($has_in) {
            return $this->renderJson([],"该登录名已存在，请换一个试试");
        }

        $info = User::find()->where(['uid'=>$id])->one();
        if ($info) {
            $model_user = $info;
        }else{
            $model_user = new User();
            $model_user->setSalt();
            $model_user->create_time = $date_now;
        }

        $model_user->nickname = $nickname;
        $model_user->mobile = $mobile;
        $model_user->email = $email;
        $model_user->login_name = $login_name;
        $model_user->avatar = ConstantMapService::$default_avater;
        if ($login_pwd != ConstantMapService::$default_password) {
            $model_user->setPassword($login_pwd);
        }
        $model_user->update_time = $date_now;

        $model_user->save(0);
        return $this->renderJson([],"操作成功");

    }

    public function actionInfo()
    {
        $id = intval($this->get('id',0));
        $return_url = UrlService::buildWebUrl('/account/info');
        if (!$id) {
            return $this->redirect($return_url);
        }
        $info = User::find()->where(['uid'=>$id])->one();
        if (!$info) {
            return $this->redirect($return_url);
        }

        $access_list = AppAccessLog::find()->where(['uid'=>$info['uid']])
                                           ->limit(10)
                                           ->orderBy(['id' => SORT_DESC])
                                           ->all();

        return $this->render('info',[
            'info' => $info,
            'access_list' => $access_list
        ]);
    }

    public function actionOps(){
        if (!\Yii::$app->request->isPost) {
            return $this->renderJson([],"系统繁忙，请稍后再试",-1);
        }

        $uid = intval($this->post("uid",0));
        $act = trim($this->post("act",""));

        if (!$uid) {
            return $this->renderJson([], "请选择要操作的账户", -1);
        }

        if (!in_array($act, ["remove","recover"])) {
            return $this->renderJson([],"操纵有误，请重试");
        }

        $user_info = User::find()->where(['uid'=>$uid])->one();
        if (!$user_info) {
            return $this->renderJson([],"您指定的账户不存在",-1);
        }

        switch ($act) {
            case "remove":
                $user_info->status = 0;
                break;
            case "recover":
                $user_info->status = 1;
        }
        $user_info->update_time = date("Y-m-d H:i:s");
        $user_info->update(0);

        return $this->renderJson([],"操作成功");
    }
}