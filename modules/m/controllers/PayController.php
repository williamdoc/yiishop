<?php

namespace app\modules\m\controllers;

use yii\web\Controller;

/**
 * Default controller for the `m` module
 */
class PayController extends Controller
{
    public $layout = "main";
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionBuy()
    {
        return $this->render('buy');
    }
}
