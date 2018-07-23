<?php
namespace app\modules\web\controllers;
use app\modules\web\controllers\common\BaseController;

class QrcodeController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSet()
    {
        return $this->render('set');
    }

}