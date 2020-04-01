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
                <form class="layui-form" method="post" class="layui-form layui-form-pane">
                  <div class="layui-form-item">
                      <label for="name" class="layui-form-label">
                          <span class="x-red">*</span>分类名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="name" name="name"  lay-verify="required|name"
                          autocomplete="off" class="layui-input" value="<?=$info?$info['class_name']:'';?>">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <input type="hidden" id="id" name="id" value="<?=$info?$info['id']:'';?>">
                      <button  class="layui-btn" lay-filter="execute" lay-submit="">
                          确定
                      </button>
                  </div>
              </form>
            </div>
        </div>


        

 <?php $this->endBody() ?>
 </body>

 <script>
 layui.use(['layer','form'],
            function() {
                $ = layui.jquery;
                var form = layui.form;
                var layer = layui.layer;                    

          

                form.on('submit(execute)', function(data){ //监听提交
                    console.log(data);
                    //发异步，把数据提交给php
                    var articleFrom = data.field;
                    $.ajax({
                        type:"POST",
                        url:"/access-class/execute",
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

            });</script>
 </html>
<?php $this->endPage() ?>

