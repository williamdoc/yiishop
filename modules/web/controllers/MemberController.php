<?php
namespace app\modules\web\controllers;
use app\modules\web\controllers\common\BaseController;

class MemberController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSet()
    {
        return $this->render('set');
    }

    public function actionInfo()
    {
        return $this->render('info');
    }

    public function actionComment()
    {
        return $this->render('comment');
    }
}