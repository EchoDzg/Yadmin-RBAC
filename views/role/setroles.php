<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
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
</head>
<body>
<?php $this->beginBody() ?>

<div class="layui-fluid">
        <div class="layui-row">
            <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="hidden" id="role_id" name="id" value="<?= $model['id'] ?>">
                        <input type="text" id="name" name="name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="<?= $model['name'] ?>">
                    </div>
                </div>
                <!--
                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="desc" name="desc" class="layui-textarea"></textarea>
                    </div>
                </div>
                -->
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="addroles">修改</button>
              </div>
            </form>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
        
    
          //监听提交
          form.on('submit(addroles)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            var articleFrom = data.field;
            $.ajax({
                type:"POST",
                url:"/role/setroles",
                data:articleFrom,
                dataType:"JSON",
                success:function (data) {
                    
                    if(data.code==0){
                        layer.alert(data.msg, {icon: 6},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                            window.parent.location.reload();
                        });
                    }else{

                        layer.msg(data.msg, {icon: 5});

                    }
   
                    
                    
                }
            });
           
            return false;
          });


          
          
        });
    </script>

</html>
<?php $this->endPage() ?>