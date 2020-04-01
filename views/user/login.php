<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="/x-admin/css/font.css">
    <link rel="stylesheet" href="/x-admin/css/login.css">
    <link rel="stylesheet" href="/x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/x-admin/lib/layui/layui.js" charset="utf-8"></script>
     
</head>
<body class="login-bg">
<?php $this->beginBody() ?>
 
<div class="login layui-anim layui-anim-up">
        <div class="message">Y-admin1.0-管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form class="layui-form" method="post" class="layui-form layui-form-pane">
 
            <input name="username"   placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
     
<?php echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>''],'template'=>'{image}']); ?>

<input name="verification" lay-verify="required" placeholder="验证码"  type="text" class="layui-input">

            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
 
        </form>
    </div>

    <!-- 底部结束 -->

<?php $this->endBody() ?>
</body>

<script>
 layui.use(['layer','form'],
            function() {
                $ = layui.jquery;
                var form = layui.form;
                var layer = layui.layer;                    

          

                form.on('submit(login)', function(data){ //监听提交
                    console.log(data);
                    //发异步，把数据提交给php
                    var articleFrom = data.field;
                    
                    $.ajax({
                        type:"POST",
                        url:"/user/vlogin",
                        data:articleFrom,
                        dataType:"JSON",
                        success:function (data) {
                            
                            if(data.code==0){
                                
                            }else{

                                layer.msg(data.msg, {icon: 5});
                                $.ajax({
                                //使用ajax请求site/captcha方法，加上refresh参数，接口返回json数据
                                    url: "/user/captcha?refresh",
                                    dataType: 'json',
                                    cache: false,
                                    success: function (data) {
                                    //将验证码图片中的图片地址更换
                                        $("#captchaimg").attr('src', data['url']);
                                    }
                                });
                            }
        
                            
                            
                        }
                    });
                
                    return false;
                });

            });</script>
</html>
<?php $this->endPage() ?>
