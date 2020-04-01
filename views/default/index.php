<ul class="layui-tab-title">
    <li class="home">
    <i class="layui-icon">&#xe68e;</i>我的桌面</li>
</ul>
<div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
        <dl>
                <dd data-type="this">关闭当前</dd>
                <dd data-type="other">关闭其它</dd>
                <dd data-type="all">关闭全部</dd>
        </dl>
</div>
<div class="layui-tab-content">


        <div class="layui-tab-item layui-show">
                         
                <!--内容区域-->
                <div class="layui-fluid">
                    <div class="layui-row layui-col-space15">
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-body ">
                                    <blockquote class="layui-elem-quote">欢迎管理员：
                                    <?php if( isset( $this->params['current_user']) ):?>
                                    <span class="x-red"><?=$this->params['current_user']['name'];?></span>！当前时间:<?=$info?$info['date_now']:'';?>
                                    <?php endif;?>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
 
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-header">系统信息</div>
                                <div class="layui-card-body ">
                                    <table class="layui-table">
                                        <tbody>
                                                <th>服务器地址</th>
                                                <td><?=$info?$info['server_address']:'';?></td></tr>
                                            <tr>
                                                <th>操作系统</th>
                                                <td><?=$info?$info['operating_system']:'';?></td></tr>
                                            <tr>
                                                <th>运行环境</th>
                                                <td><?=$info?$info['running_environment']:'';?></td></tr>
                                            <tr>
                                                <th>PHP版本</th>
                                                <td><?=$info?$info['php_version']:'';?></td></tr>
                                            <tr>
                                                <th>PHP运行方式</th>
                                                <td><?=$info?$info['php_works']:'';?></td></tr>
                                            <tr>
                                                <th>MYSQL版本</th>
                                                <td><?=$info?$info['mysql_version']:'';?></td></tr>
                                            <tr>
                                                <th>Yii版本</th>
                                                <td><?=$info?$info['yii_version']:'';?></td></tr>
                                            <tr>
                                                <th>上传附件限制</th>
                                                <td><?=$info?$info['upload_limits']:'';?></td></tr>
                                            <tr>
                                                <th>执行时间限制</th>
                                                <td><?=$info?$info['execution_time_limit']:'';?></td></tr>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-header">开发团队</div>
                                <div class="layui-card-body ">
                                    <table class="layui-table">
                                        <tbody>
                                            <tr>
                                                <th>版权所有</th>
                                                <td>开源
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>开发者</th>
                                                <td>听风(907226763@qq.com)</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <style id="welcome_style"></style>
                        <div class="layui-col-md12">
                            <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,百度Echarts,jquery,本系统基于x-admin作为前端采用Yii 2.0 开发。</blockquote></div>
                    </div>
                </div>
                </div>
            <!--内容区域-->
            
        </div>
</div>


