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

<div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">系统管理</a>
            <a href="">权限管理</a>
            <a>
              <cite>数据列表</cite>
            </a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                           <form class="layui-form" method="post" class="layui-form layui-form-pane">
                                
                                <div class="layui-inline layui-show-xs-block">
                                    <select name="class_id">
                                      <option>权限分类</option>
                                         <?php if( $access_class_list ):?>

                                         <?php foreach ( $access_class_list as $_access_item ):?>
                                        
                                            <option value="<?=$_access_item['id'];?>"><?=$_access_item['class_name'];?></option>
                                      

                                        <?php endforeach;?>

                                        <?php endif;?>
                                    </select>
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="title"  placeholder="权限名称" autocomplete="off" class="layui-input" lay-verify="required|title">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="controller"  placeholder="控制器" autocomplete="off" class="layui-input" lay-verify="required|controller">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="method"  placeholder="方法" autocomplete="off" class="layui-input" lay-verify="required|method">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                <button class="layui-btn"  lay-filter="execute" lay-submit="" ><i class="layui-icon"></i>增加</button>
                                </div>
                            </form>
                        </div>
 
                        <div class="layui-card-body ">
                            <table id="tpl" class="layui-hide">
                            </table>
                        </div>
             
                    </div>
                </div>
            </div>
        </div> 

<?php $this->endBody() ?>
</body>
 
<script type="text/html" id="manageTpl">
 
 
    
    <a title="删除" onclick="member_del(this,'{{ d.id }}')" href="javascript:;">
                                      <i class="layui-icon"></i>
    </a>
 
</script>
 
<script>
    layui.use(['form','table'], function(){
       
        table = layui.table;
        laypage = layui.laypage;
        $ = layui.jquery;
        var form = layui.form;
       
        table.render({
          id: 'equipmentTable',
          elem: '#tpl'
          ,method:'post'
          ,url: '/access/index' //数据接口
          ,page: true //开启分页
          ,cols: [[ //表头
            {field: 'id', title: 'ID', sort: true}
            ,{field: 'urls', title: '权限规则', }
            ,{field: 'title', title: '权限名称', }
            ,{field: 'class_name', title: '所属分类', }
            ,{ title: '操作',  templet: '#manageTpl'}
          ]]
          ,page: true
        });
       
        var $ = layui.$, active = {
            reload: function(){
                
                var tReload = $('#tReload');
                  
                //执行重载
                table.reload('equipmentTable', {
                    page: {
                    curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        name: tReload.val()
                    }
                }, 'data');
            }
        };
        
        $('.reloadTable .layui-btn').on('click', function(){
            
            var type = $(this).data('type');
           
            active[type] ? active[type].call(this) : '';
        });


        //监听提交
        form.on('submit(execute)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            var articleFrom = data.field;
            $.ajax({
                type:"POST",
                url:"/access/execute",
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

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.ajax({
                        type:"POST",
                        url:"/access/member-del",
                        data:{  
                                id : id
                        }, 
                        dataType:"JSON",
                        success:function (data) {
                                if(data.code==0){
                                    $(obj).parents("tr").remove();
                                    layer.msg(data.msg,{icon:1,time:1000});
                                }else{
                                    layer.msg(data.msg, {icon: 5});
                                }
                        }
              });

          });
      }
 
</script>
</html>
<?php $this->endPage() ?>