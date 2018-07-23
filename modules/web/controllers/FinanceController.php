<?php
namespace app\modules\web\controllers;
use app\modules\web\controllers\common\BaseController;

class FinanceController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAccount()
    {
        return $this->render('account');
    }

    public function actionPayInfo()
    {
        return $this->render('pay_info');
    }

}