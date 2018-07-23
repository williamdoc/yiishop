<?php
namespace app\modules\web\controllers;
use app\modules\web\controllers\common\BaseController;

class BookController extends BaseController
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

    public function actionImages()
    {
        return $this->render('images');
    }

    public function actionCat()
    {
        return $this->render('cat');
    }

    public function actionCatSet()
    {
        return $this->render('cat_set');
    }

}