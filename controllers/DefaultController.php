<?php

namespace app\controllers;

use app\common\components\BaseWebController;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class DefaultController extends BaseWebController
{
    /**
     * {@inheritdoc}
     */
    //public $layout = false;
    public function actionIndex()
    {
        return $this->render("index");
    }
}
