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
            <a href="">管理员管理</a>
            <a href="">管理员列表</a>
          
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body reloadTable">
                                
                    
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input" name="name" id="tReload" autocomplete="off" placeholder="请输入管理员姓名">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn" data-type="reload">搜索</button>
                                </div>
                        </div>
                        <div class="layui-card-header">
                          
                            <button class="layui-btn" onclick="xadmin.open('添加管理员','<?=UrlService::buildUrl('/user/set-admin') ?>',600,400)"><i class="layui-icon"></i>添加</button>
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
<script type="text/html" id="statusTpl">
    {{# if (d.status == '1') { }}
    <span class="layui-btn layui-btn-normal layui-btn-mini td-status">已启用</span>
    {{# } else { }}
    <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled td-status">已停用</span>
    {{# } }}
</script>
<script type="text/html" id="manageTpl">

    {{# if (d.status == '1') { }}
        <a onclick="member_stop(this,'{{ d.id }}')" href="javascript:;" title="启用">
                                        <i class="layui-icon">&#xe601;</i>
        </a>
    {{# } else { }}
        <a onclick="member_stop(this,'{{ d.id }}')" href="javascript:;" title="停用">
        <i class="layui-icon">&#xe62f;</i>
        </a>
    {{# } }}

    <a title="编辑" onclick="xadmin.open('编辑','/user/set-admin?id={{ d.id }}',600,400)" href="javascript:;">
                                      <i class="layui-icon"></i>
    </a>
    {{# if (d.id != '1') { }}
    <a title="删除" onclick="member_del(this,'{{ d.id }}')" href="javascript:;">
                                      <i class="layui-icon"></i>
    </a>
    {{# } }}
</script>
 
<script>
    layui.use(['table'], function(){
       
        table = layui.table;
        laypage = layui.laypage;
       
        table.render({
          id: 'equipmentTable',
          elem: '#tpl'
          ,method:'post'
          ,url: '/user/index' //数据接口
          ,page: true //开启分页
          ,cols: [[ //表头
            {field: 'id', title: 'ID', sort: true}
            ,{field: 'name', title: '姓名', }
            ,{field: 'email', title: '邮箱', }
            ,{field:'status', title: '状态',  templet: '#statusTpl'} 
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
 
  
    });

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.ajax({
                        type:"POST",
                        url:"/user/member-del",
                        data:{  
                                id : id
                        }, 
                        dataType:"JSON",
                        success:function (data) {
                                if(data.code==0){
                                    $(obj).parents("tr").remove();
                                    layer.msg(data.msg,{icon:1,time:1000});
                                }else{
                                    layer.msg(data.msg,{icon:2,time:2000});
                                }
                        }
              });

          });
      }

 

    /*用户-停用*/
    function member_stop(obj,id){

        if($(obj).attr('title')=='启用'){
            var msg = "确认要停用吗？";
        }else{
            var msg = "确认要启用吗？";
        }

        layer.confirm(msg,function(index){
                
                if($(obj).attr('title')=='启用'){
                      up_status(id,0,obj,'停用','&#xe601;',layer);//停用
                }else{
                      up_status(id,1,obj,'启用','&#xe62f;',layer);//启用
                }
                
            });
      }

      //Ajax 更改状态
      function up_status(id,status,obj,title,i,layer){
           
                $.ajax({
                        type:"POST",
                        url:"/user/up-status",
                        data:{  
                                id : id,
                                status : status
                        }, 
                        dataType:"JSON",
                        success:function (data) {

                                if(data.code==0){
                                    $(obj).attr('title',title)
                                    $(obj).find('i').html(i);

                                    if(title=='启用'){
                                        $(obj).parents("tr").find(".td-status").removeClass('layui-btn-disabled').html('已启用');
                                        layer.msg('已启用!',{icon: 6,time:1000});
                                      
                                    }else{
                                        $(obj).parents("tr").find(".td-status").addClass('layui-btn-disabled').html('已停用');
                                        layer.msg('已停用!',{icon: 5,time:1000});
                                    }
                                }else{
                                    layer.msg(data.msg, {icon: 5});
                                }
         
                        }
              });
      }
</script>
</html>
<?php $this->endPage() ?>