<?php
use app\common\services\UrlService;
//引入资源包
use app\assets\AppAsset;
AppAsset::register($this);//将当前视图页面注入进来

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>微信图书商城</title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<div class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-collapse collapse pull-left">
            <ul class="nav navbar-nav ">
                <li><a href="<?=UrlService::buildWwwUrl('/');?>">首页</a></li>
                <li><a target="_blank" href="http://www.54php.cn/">博客</a></li>
                <li><a href="<?=UrlService::buildWebUrl('/user/login');?>">管理后台</a></li>
            </ul>
        </div>
    </div>
</div>

<?=$content;?>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>