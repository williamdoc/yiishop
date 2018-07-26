<?php
namespace app\modules\web\controllers;
use app\models\brand\BrandSetting;
use app\modules\web\controllers\common\BaseController;

class BrandController extends BaseController
{
    //品牌详情
    public function actionInfo()
    {
        $info = BrandSetting::find()->one();
        return $this->render('info',[
            'info' => $info
        ]);
    }
    //品牌编辑
    public function actionSet()
    {
        if (\Yii::$app->request->isGet) {
             $info = BrandSetting::find()->one();
             return $this->render('set',[
                 'info' => $info
             ]);
        }

        $name = trim($this->post('name',''));
        $image_key = trim($this->post('image_key',''));
        $mobile = trim($this->post('mobile',''));
        $address = trim($this->post('address',''));
        $description = trim($this->post('description',''));
        $date_now = date("Y-m-d H:i:s");
        if (mb_strlen($name) < 1) {
            return $this->renderJson([],"请输入符合规范的品牌名",-1);
        }

        if (!$image_key) {
            return $this->renderJson([],"请上传品牌Logo",-1);
        }
        if (mb_strlen($mobile) < 1) {
            return $this->renderJson([],"请输入符合规范的手机号码",-1);
        }
        if (mb_strlen($address) < 1) {
            return $this->renderJson([],"请输入符合规范的地址",-1);
        }
        if (mb_strlen($description) < 1) {
            return $this->renderJson([],"请输入符合规范的描述",-1);
        }

        $info = BrandSetting::find()->one();
        if ($info) {
            $model_brand = $info;
        } else {
            $model_brand = new BrandSetting();
            $model_brand->create_time = $date_now;
        }

        $model_brand->name = $name;
        $model_brand->logo = $image_key;
        $model_brand->mobile = $mobile;
        $model_brand->address = $address;
        $model_brand->description = $description;
        $model_brand->update_time = $date_now;

        $model_brand->save(0);

        return $this->renderJson([],"操作成功");

    }
    //品牌相册
    public function actionImages()
    {
        return $this->render('images');
    }
}