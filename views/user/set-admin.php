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
                          <span class="x-red">*</span>姓名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="name" name="name" required="" lay-verify="required"
                          autocomplete="off" class="layui-input" value="<?=$info?$info['name']:'';?>">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>将会成为您唯一的登入名
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_pass" class="layui-form-label">
                          <span class="x-red">*</span>密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="L_pass" name="pass" required="" lay-verify="pass"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          6到16个字符
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                          <span class="x-red">*</span>确认密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          <span class="x-red">*</span>邮箱
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="L_email" name="email" required="" lay-verify="email"
                          autocomplete="off" class="layui-input" value="<?=$info?$info['email']:'';?>">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label class="layui-form-label"><span class="x-red">*</span>角色</label>
                      <div class="layui-input-block">

                            <?php if( $role_list ):?>

                                <?php foreach ( $role_list as $_role_item ):?>

                                  <input type="checkbox" name="role_ids[]" lay-skin="primary" title="<?=$_role_item['name'];?>" value="<?=$_role_item['id'];?>" 
                                     <?php if( in_array( $_role_item['id'],$related_role_ids ) ) :?> checked <?php endif;?>
                                  >
                                
                                  <?php endforeach;?>
   
                            <?php endif;?>
                      </div>
                  </div>
          
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <input type="hidden" id="id" name="id" value="<?=$info?$info['id']:'';?>">
                      <button  class="layui-btn" lay-filter="set-admin" lay-submit="">
                          确定
                      </button>
                  </div>
              </form>
            </div>
        </div>


        

 <?php $this->endBody() ?>
 </body>

 <script>
 layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;
                //自定义验证规则
                form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return '昵称至少得5个字符啊';
                        }
                    },
                    pass: [/(.+){6,12}$/, '密码必须6到12位'],
                    repass: function(value) {
                        if ($('#L_pass').val() != $('#L_repass').val()) {
                            return '两次密码不一致';
                        }
                    }
                });
                //监听提交
                form.on('submit(set-admin)', function(data){
                    console.log(data);
                    //发异步，把数据提交给php
                    var articleFrom = data.field;
                    $.ajax({
                        type:"POST",
                        url:"/user/set-admin",
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

