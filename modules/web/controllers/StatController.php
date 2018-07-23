<?php
namespace app\modules\web\controllers;
use yii\web\Controller;

class StatController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMember()
    {
        return $this->render('member');
    }

    public function actionProduct()
    {
        return $this->render('product');
    }

    public function actionShare()
    {
        return $this->render('share');
    }

}