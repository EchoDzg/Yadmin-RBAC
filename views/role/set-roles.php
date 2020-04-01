<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\services\MenuService;
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
                        <input type="text" id="name" name="name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="<?=$role_info?$role_info['name']:'';?>" >
                    </div>
                </div>
                <?php if( MenuService::getPermissionNode() ):?>
                    <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                            <?php foreach ( MenuService::getPermissionNode() as $_node_item ):?>
                            <tr>
                            
                                <td>
                                    <input type="checkbox" name="like1[write]" lay-skin="primary" lay-filter="father" title="<?=$_node_item['class_name'];?>">
                                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span><?=$_node_item['class_name'];?></span><i class="layui-icon layui-icon-ok"></i></div>
                                </td>
                                <td>
                                    <?php if( $_node_item['data'] ):?>

                                        <div class="layui-input-block">
                                            <?php foreach ( $_node_item['data'] as $_children_item ):?>
                                                <input name="accessids[]" lay-skin="primary" type="checkbox" title="<?=$_children_item['title'];?>" value="<?=$_children_item['id'];?>"
                                                 <?php if( in_array( $_children_item['id'],$role_access_ids ) ) :?> checked <?php endif;?>
                                                >
                                            <?php endforeach;?>
                                        </div>

                                    <?php endif;?>
                                </td>
                            </tr>
                           
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php endif;?>
          
                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="desc" name="desc" class="layui-textarea"><?=$role_info?$role_info['describe']:'';?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                <input type="hidden" id="id" name="id" value="<?=$role_info?$role_info['id']:'';?>">
                <button class="layui-btn" lay-submit="" lay-filter="set-roles">确定</button>
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
          form.on('submit(set-roles)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            var articleFrom = data.field;
            $.ajax({
                type:"POST",
                url:"/role/set-roles",
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

          form.on('checkbox(father)', function(data){

                if(data.elem.checked){
                    $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                    form.render(); 
                }else{
                $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                    form.render();  
                }

          });
          
          
        });
    </script>

</html>
<?php $this->endPage() ?>