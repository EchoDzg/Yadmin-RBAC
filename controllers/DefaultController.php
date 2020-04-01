<?php
/**
 * Class DefaultController
 */

namespace app\controllers;

use app\controllers\common\BaseController;

class DefaultController extends  BaseController {
    
    /**
     * 默认首页
     */
	public function actionIndex(){
        $this->layout = "main"; //设置使用的布局文件
         
        $info = [
            'date_now' => date("Y-m-d H:i:s"), //当前时间
            'operating_system' => php_uname('s'), //操作系统
            'server_address' => $_SERVER['SERVER_ADDR'], //服务器地址
            'running_environment' => $_SERVER["SERVER_SOFTWARE"], //运行环境
            'php_version' =>  PHP_VERSION, //PHP版本
            'php_works' => php_sapi_name(), //PHP运行方式
            'mysql_version' => \Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION), //MYSQL版本
            'yii_version' => \Yii::getVersion(), //Yii 版本
            'upload_limits' => get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件", //上传附件限制
            'execution_time_limit' => get_cfg_var("max_execution_time")."秒 " //执行时间限制
        ];

		return $this->render("index",compact('info'));
    }
    
    /**
     * 无权提示界面
     */
    public function actionError(){
        
        return $this->render("error");
    }


}