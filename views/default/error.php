<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\services\UrlService;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="x-admin-sm">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link rel="stylesheet" href="/x-admin/css/login.css">
</head>
<body>
<?php $this->beginBody() ?>
<div class="layui-container">
           <div class="fly-panel"> 
            <div class="fly-none"> 
             <h2><i class="layui-icon layui-icon-404"></i></h2> 
              <p>该角色无权限访问此页面<a href=""> 可联系 </a>管理员开通~</p> 
            </div>
           </div>
 </div>
<?php $this->endBody() ?>
</body>
 
 
</html>
<?php $this->endPage() ?>