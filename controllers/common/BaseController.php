<?php
/**
 * Class BaseController
 */

namespace app\controllers\common;


use app\models\Access;
use app\models\AppAccessLog;
use app\models\RoleAccess;
use app\models\User;
use app\models\UserRole;
use app\services\UrlService;
use yii\web\Controller;
use Yii;
//是以后所有控制器的基类，并且集成常用公用方法
class BaseController extends  Controller{

	protected $auth_cookie_name = "tf_666";
	protected $current_user = null;//当前登录人信息
	protected $allowAllAction = [
		'user/lo',
		'user/vlogin',
		'user/captcha'
	];

	public $ignore_url = [
		'error/forbidden' ,
		'user/vlogin',
		'user/lo',
		'default/index',
		'default/error',
		'user/captcha'
	];

	public $privilege_urls = [];//保存去的权限链接

	//本系统所有页面都是需要登录之后才能访问的，  在框架中加入统一验证方法
	public function beforeAction($action) {
	
        $this->layout = false; //除默认首页外 其他界面不使用布局文件
		$login_status = $this->checkLoginStatus();
		
		
		if ( !$login_status && !in_array( $action->uniqueId,$this->allowAllAction )  ) {
		
			if(Yii::$app->request->isAjax){
				$this->renderJSON([],"未登录,请返回用户中心",-302);
			}else{
				$this->redirect( UrlService::buildUrl("/user/lo") );//返回到登录页面
			}
			return false;
		}
	
		//不需要进行权限判断的界面
		if( in_array( $action->getUniqueId(),$this->ignore_url ) ){
			return true;
		}
		
		//判断当前访问的链接 是否在 所拥有的权限列表中
	 
		 if( !$this->checkPrivilege( $action->getUniqueId() ) ){

			if(Yii::$app->request->isAjax){
				$this->renderJSON([],"该角色暂无权限,可联系管理员开通~",-302); 
			}else{
				$this->redirect(UrlService::buildUrl("/default/error"));
			}
			
		}												

		return true;
	}
		 
	//检查是否有访问指定链接的权限
	public function checkPrivilege( $url ){
	
		
		//如果是超级管理员 也不需要权限判断
		if( $this->current_user && $this->current_user['is_admin'] ){
			 return true;
		}
	
		 


		if( !$uid && $this->current_user ){
			$uid = $this->current_user->id;
		}

		//查询所属角色
		$Role = UserRole::find()->where(['uid'=> $uid])->select('role_id')->asArray()->all();
		$related_role_ids = array_column($Role,"role_id");
		 

		$access_urls = RoleAccess::find()
		->where([  
			'in', 'role_id', [1, 3, 5, 6]  
		])
		->where([ 'role_id' => $related_role_ids ])
		->select('y_access.urls as urls')
		->join('LEFT JOIN','y_access','y_access.id=y_role_access.access_id')
		->asArray()
		->column();
	 
		if( in_array( $url,$access_urls ) ){
			return true;
		}else{
			return false;
		}

	}

 


	//验证登录是否有效，返回 true or  false
	protected function checkLoginStatus(){
		$request = Yii::$app->request;
		$cookies = $request->cookies;
		$auth_cookie = $cookies->get($this->auth_cookie_name);
		if(!$auth_cookie){
			return false;
		}
		list($auth_token,$uid) = explode("#",$auth_cookie);

		if(!$auth_token || !$uid){
			return false;
		}

		if( $uid && preg_match("/^\d+$/",$uid) ){
			$userinfo = User::findOne([ 'id' => $uid ]);
			if(!$userinfo){
				return false;
			}
			//校验码
			if($auth_token != $this->createAuthToken($userinfo['id'],$userinfo['name'],$userinfo['email'],$_SERVER['HTTP_USER_AGENT'])){
				return false;
			}
			$this->current_user = $userinfo;
			$view = Yii::$app->view;
			$view->params['current_user'] = $userinfo;
			return true;
		}
		return false;
	}

	//设置登录态cookie
	public  function createLoginStatus($userinfo){
		$auth_token = $this->createAuthToken($userinfo['id'],$userinfo['name'],$userinfo['email'],$_SERVER['HTTP_USER_AGENT']);
		$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
			'name' => $this->auth_cookie_name,
			'value' => $auth_token."#".$userinfo['id'],
			'expire'=>time()+3600
		]));
	}

	//用户相关信息生成加密校验码函数
	public function createAuthToken($uid,$name,$email,$user_agent){
		return md5($uid.$name.$email.$user_agent);
	}

	//统一获取post参数的方法
	public function post($key, $default = "") {
		return Yii::$app->request->post($key, $default);
	}

	//统一获取get参数的方法
	public function get($key, $default = "") {
		return Yii::$app->request->get($key, $default);
	}

	/*
	 * 封装json返回值，主要用于js ajax 和 后端交互返回格式
	 * data:数据区 数组
	 * msg: 此次操作简单提示信息
	 * code: 状态码 200 表示成功，http 请求成功 状态码也是200
	 */
	public function renderJSON($data=[], $msg ="ok", $code = 200,$count = 0){
		header('Content-type: application/json');//设置头部内容格式
		echo json_encode([
			"code" => $code,
			"msg"   =>  $msg,
			'count' =>$count,
			"data"  =>  $data,
			"req_id" =>  uniqid(),
		]);
		return Yii::$app->end();//终止请求直接返回
	}


 
}