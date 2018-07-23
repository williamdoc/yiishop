<?php

namespace app\controllers;

use app\common\components\BaseWebController;
use app\common\services\AppLogService;
use app\models\log\AppLog;
use Yii;
use yii\filters\AccessControl;
use yii\log\FileTarget;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class ErrorController extends BaseWebController
{
    //public $layout = false;
    /**
     * {@inheritdoc}
     */
    public function actionError()
    {
        //记录错误信息到文件和数据库
        $error = \Yii::$app->errorHandler->exception;
        $err_msg = '';
        if($error){
            $file = $error->getFile();
            $line = $error->getLine();
            $message = $error->getMessage();
            $code = $error->getCode();

            $log = new FileTarget();
            $log->logFile = \Yii::$app->getRuntimePath()."/log/err.log";

            $err_msg = $message."  [file:{$file}][line:{$line}][code:{$code}][url:{$_SERVER[REQUEST_URI]}][POST_DATA:".http_build_query($_POST)."]";

            $log->messages[] = [
                $err_msg,
                1,
                'application',
                microtime(true)
            ];

            $log->export();

            //TODO 写入到数据库
            AppLogService::addErrorLog(\Yii::$app->id,$err_msg);
        }
        return $this->render("error",["err_msg" => $err_msg]);
    }
}
