<?php
namespace app\modules\web\controllers;
use app\modules\web\controllers\common\BaseController;

class DashboardController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}