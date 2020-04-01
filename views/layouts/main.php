<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\services\UrlService;
use app\services\MenuService;
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
</head>
<body class="index">
<?php $this->beginBody() ?>

 <!-- 顶部开始 -->
 <div class="container">
            <div class="logo">
                <a href="./index.html">Y-admin v2.0</a></div>
            <div class="left_open">
                <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
            </div>
            <ul class="layui-nav right" lay-filter="">
                <li class="layui-nav-item">

                    <?php if( isset( $this->params['current_user']) ):?>
                        <a href="javascript:;"><?=$this->params['current_user']['name'];?></a>
                    <?php endif;?>

                    <dl class="layui-nav-child">
                        <!-- 二级菜单 -->
                        <dd>
                            <a href="<?=UrlService::buildUrl('/user/login')?>">切换账号</a></dd>
                    </dl>
                </li>
               
            </ul>
        </div>
        <!-- 顶部结束 -->
        <!-- 中部开始 -->
        <!-- 左侧菜单开始 -->
        <div class="left-nav">
            <div id="side-nav">
                <ul id="nav">

               
                        <?php if( MenuService::getMenu() ):?>

                        <?php foreach ( MenuService::getMenu() as $_mend_item ):?>

                            <li>
                                <a href="javascript:;">
                                    <i class="iconfont left-nav-li" lay-tips="<?=$_mend_item['name'];?>"><?=$_mend_item['icon'];?></i>
                                    <cite><?=$_mend_item['name'];?></cite>
                                    <i class="iconfont nav_right">&#xe697;</i></a>

                                    <?php if( $_mend_item['children'] ):?>

                                        <ul class="sub-menu">

                                          <?php foreach ( $_mend_item['children'] as $_children_item ):?>
                                            <li>
                                                <a onclick="xadmin.add_tab('<?=$_children_item['name'];?>','<?=UrlService::buildUrl($_children_item['route'])?>')">
                                                    <i class="iconfont"><?=$_children_item['icon'];?></i>
                                                    <cite><?=$_children_item['name'];?></cite></a>
                                            </li>
                                          <?php endforeach;?>
                                    
                                        </ul>

                                    <?php endif;?>
                            </li>

                        <?php endforeach;?>

                        <?php endif;?>

                     </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- <div class="x-slide_left"></div> -->
        <!-- 左侧菜单结束 -->
        <!-- 右侧主体开始 -->
            <div class="page-content">
            <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
                <?=$content;?>
                <div id="tab_show"></div>
            </div>
        </div>
        <div class="page-content-bg"></div>
        <style id="theme_style"></style>
        <!-- 右侧主体结束 -->
  
        <!-- 中部结束 -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
