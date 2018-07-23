<?php

namespace app\modules\m\controllers;

use yii\web\Controller;

/**
 * Default controller for the `m` module
 */
class ProductController extends Controller
{
    public $layout = "main";
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionInfo()
    {
        $this->layout = false;
        return $this->render('info');
    }
    public function actionOrder()
    {
        return $this->render('order');
    }
}
