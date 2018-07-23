<?php
namespace app\modules\m\controllers;
use yii\web\Controller;

class UserController extends Controller
{
    public $layout = "main";

    public function actionIndex(){
        return $this->render('index');
    }
    public function actionCart(){
        return $this->render('cart');
    }
    public function actionAddress(){
        return $this->render('address');
    }
    public function actionAddressSet(){
        return $this->render('address_set');
    }
    public function actionComment(){
        return $this->render('comment');
    }
    public function actionCommentSet(){
        return $this->render('comment_set');
    }
    public function actionFav(){
        return $this->render('fav');
    }
    public function actionOrder(){
        return $this->render('order');
    }
    public function actionBind(){
        return $this->render('bind');
    }

}