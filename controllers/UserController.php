<?php

namespace app\controllers;

use yii\filters\AccessControl;
use app\controllers\common\BaseController;
use app\models\User;
use app\services\UrlService;
use app\models\Role;
use app\models\UserRole;
use app\models\ContactForm;


class UserController extends  BaseController{

 
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'width' => 150,
                'height' => 50,
                'maxLength' => 4, //生成的验证码最大长度
                'minLength' => 4  //生成的验证码最短长度
            ],
        ];
    }

	//用户管理列表
	public function actionIndex(){
        if(\Yii::$app->request->isPost){
            
            $limit = $this->post("limit","");
            $page = $this->post("page","");
            $name = $this->post("name","");
            $page = max(1, $page);
            $limit or $limit = 10;
            $offset = ($page - 1) * $limit;

            // 创建一个 DB 查询 角色数据
            $query = User::find()->orderBy(['id'=> SORT_DESC]);
            if($name){
                $query->where(['like', 'name',$name]);
            }
            
            // 得到角色数据的总数 
            $count = $query->count();
          
            // 分页
            $Role = $query->offset($offset)
                ->limit($limit)
                ->asarray()
                ->all();

            return $this->renderJSON($Role,"数据列表数据!",0,$count);

        }else{
            
            return  $this->render("index");

        }
    }

    //处理添加或编辑管理员
    public function actionSetAdmin(){
         
        if(\Yii::$app->request->isGet){
       
            $id = $this->get('id',0);
            $info = [];

            if( $id ){
                
                $info = User::find()->where(['status' => 1,'id'=> $id])->one();

            }
            //取出所有角色
            $role_list = Role::find()->orderBy( ['id'=> SORT_DESC])->all();
            //取出已分配角色
            $user_role_list = UserRole::find()->where(['uid'=>$id])->asArray()->all();
            $related_role_ids = array_column($user_role_list,"role_id");

            return  $this->render("set-admin",compact(
                "info",
                "role_list",
                "related_role_ids"
            ));

          
        
        }

        $id = intval( $this->post('id',0) );
        $name = trim( $this->post('name',0) );
        $pass = trim( $this->post('pass',0) );
        $email = trim( $this->post('email',0) );
        $role_ids =  $this->post('role_ids',[]);
         
        $date_now= date("Y-m-d H:i:s");

        //查询该有限是否已经存在
        if( User::find()->where(['email' => $email ])->andWhere([ '!=','id',$id ])->count() ){
            return $this->renderJSON([],"邮箱已经存在~",-1);
        }

        $info = User::find()->where(['id'=> $id])->one();
        if( $info ){//如果存在则是编辑
            $model_user = $info;
        }else{//不存在就是添加
            $model_user = new User();
            $model_user->status = 1;
            $model_user->created_time = $date_now;
        }

        $model_user->name = $name;
        $model_user->password = crypt(md5($pass),$this->auth_cookie_name);
        $model_user->email = $email;
        $model_user->updated_time = date("Y-m-d H:i:s");

        if( $model_user->save(0) ){//如果用户信息保存成功，接下来保存和角色之间的关系
 
                if( $role_ids ){
                     //清空角色 对应 权限-关联关系
                     UserRole::deleteAll('uid='.$model_user->id);
                     
                     $model_user_role_arr = [];//初始化数组

                     foreach( $role_ids as $key=>$_role_id ){//将需要插入的数据放入数组
                         
                         $model_user_role_arr[$key]['uid'] = $model_user->id;
                         $model_user_role_arr[$key]['role_id'] =  $_role_id;
                         $model_user_role_arr[$key]['created_time'] =  $date_now;

                     }
                     //在将数组写入数据库
                     $UserRole = new UserRole();
                     \Yii::$app->db->createCommand()->batchInsert(
                         UserRole::tableName(),
                         ['uid','role_id','created_time'], 
                         $model_user_role_arr
                     )->execute(); 

                }
        }

        return $this->renderJSON([],"操作成功~",0);

    }

    //修改管理员状态
    public function actionUpStatus(){
         
        $User = User::find()->where(['id'=>$this->post("id","")])->one(); 
        $User->status = $this->post("status","");  
      
        if($User->save()){
            return $this->renderJSON([],"修改成功~~",0);
        }else{
            return $this->renderJSON([],"修改失败!",-1);
        }

	}

	//单条删除
	public function actionMemberDel(){
        
			$id = (int)$this->post("id","");
			if($id==1){
				return $this->renderJSON([],"禁止删除管理员~~",-1);
			}
			$User = User::find()->where(['id'=>$id])->one(); 

			if($User->delete()){
				return $this->renderJSON([],"删除成功~~",0);
			}else{
				return $this->renderJSON([],"删除失败~~",-1);
			}
	}

    //退出登录-逻辑
    public function actionLogin(){

      
         $cookies = \Yii::$app->request->cookies;

         $cookie_name = $cookies->getValue($this->auth_cookie_name, 0); //如果不存在，则返回值 en
            
         if($cookie_name){
                $cookies = \Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                    'name' => $this->auth_cookie_name,
                    'value' => null,
                ]));
          }
    
         
          return $this->render('login');
    }

    public function actionLo(){

        return $this->render('login');
    
    }
   

	//登录
	public function actionVlogin(){
      
        $username = $this->post("username",0);
        $password = $this->post("password",0);
        $captchCode = $this->post("verification",0);

        $captcha = $this->createAction('captcha')->validate($captchCode, false); //$captchCode为用户输入的验证码
        if(!$captcha){
            return $this->renderJSON([],"验证码错误~~",-1);
        }

        $user = User::find()->where(['name' => $username,'password'=> crypt(md5($password),$this->auth_cookie_name)])->one();
        if(!$user){
            return $this->renderJSON([],"账号或密码错误~~",-1);
        }
		$uid = $user->id;
		$reback_url = UrlService::buildUrl("/");
		if( !$uid ){
			return $this->redirect( $reback_url );
		}
		$user_info = User::find()->where([ 'id' => $uid ])->one();
		if( !$user_info ){
			return $this->redirect( $reback_url );
		}
		//cookie保存用户的登录态,所以cookie值需要加密，规则：user_auth_token + "#" + uid
		$this->createLoginStatus( $user_info );
        return $this->redirect( $reback_url );
        
    }
    
   
 
     
    
}