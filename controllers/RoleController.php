<?php

namespace app\controllers;

use app\controllers\common\BaseController;
use app\services\UrlService;
use app\models\Role;
use app\models\RoleAccess;

class RoleController extends  BaseController{

    //角色管理
    public function actionHome(){
        
        if(\Yii::$app->request->isPost){
            
            $limit = $this->post("limit","");
            $page = $this->post("page","");
            $name = $this->post("name","");
            $page = max(1, $page);
            $limit or $limit = 10;
            $offset = ($page - 1) * $limit;

            // 创建一个 DB 查询 角色数据
            $query = Role::find()->orderBy(['id'=> SORT_DESC]);
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
    
   

    //角色 操作
    public function actionSetRoles(){
         
        if(\Yii::$app->request->isGet){
            $id = $this->get('id',0);
            $role_info = [];
            if( $id ){
                
                $role_info = Role::find()->where(['status' => 1,'id'=> $id])->one();

            }
            //取出已分配权限
            $role_access_list = RoleAccess::find()->where(['role_id'=>$id])->asArray()->all();
            $role_access_ids = array_column($role_access_list,"access_id");
            
            return  $this->render("set-roles",compact(
                "role_info",
                "role_access_ids"
            ));
        }

        $id = intval( $this->post('id',0) );
        $name = $this->post("name","");
        $desc = $this->post("desc","");
        $access_ids =  $this->post('accessids',[]);
         
        $date_now = date("Y-m-d H:i:s");
        if(!$name) {
            return $this->renderJSON([],"请输入合法的角色名称!",-1);
        }

        //查询是否存在角色名相等的记录
        $role_info = Role::find()->where(['name' => $name])->andWhere([ '!=','id',$id ])->one();
        if($role_info){
            return $this->renderJSON([],"该角色名称已存在，请输入其他角色名称!",-1);
        }
        $info = Role::find()->where(['id'=> $id])->one();
        if( $info ){//如果存在则是编辑
            $role_model = $info;
        }else{//不存在就是添加
            $role_model = new Role();
            $role_model->created_time = $date_now;
            $role_model->status = 1;
        }

        $role_model->name =  $name;
        $role_model->updated_time = date("Y-m-d H:i:s");
        $role_model->describe = $desc;

        if($role_model->save(0)){//如果角色信息保存成功，接下来保存和角色之间的权限关系
            if( $access_ids ){
                //清空角色 对应 权限-关联关系
                RoleAccess::deleteAll('role_id='.$role_model->id);
                
                $model_user_role_arr = [];//初始化数组

                foreach( $access_ids as $key=>$_access_id ){//将需要插入的数据放入数组
                    
                    $model_user_role_arr[$key]['role_id'] = $role_model->id;
                    $model_user_role_arr[$key]['access_id'] =  $_access_id;
                    $model_user_role_arr[$key]['created_time'] =  $date_now;

                }
                //在将数组写入数据库
                $RoleAccess = new RoleAccess();
                \Yii::$app->db->createCommand()->batchInsert(
                    RoleAccess::tableName(),
                    ['role_id','access_id','created_time'], 
                    $model_user_role_arr
                )->execute(); 

           }
        }

        return $this->renderJSON([],"操作成功~~",0);
    }


    //修改角色状态
    public function actionUpStatus(){
         
        $Role = Role::find()->where(['id'=>$this->post("id","")])->one(); 
        $Role->status = $this->post("status","");  
      
        if($Role->save()){
            return $this->renderJSON([],"修改成功~~",0);
        }else{
            return $this->renderJSON([],"修改失败!",-1);
        }

    }

    //单条删除
    public function actionMemberDel(){
        
        $id = (int)$this->post("id","");
        $Role = Role::find()->where(['id'=>$id])->one(); 
   
        if($Role->delete()){
            //清空角色 对应 权限-关联关系
            RoleAccess::deleteAll('role_id='.$Role->id);
            return $this->renderJSON([],"删除成功~~",0);
        }else{
            return $this->renderJSON([],"删除失败~~",-1);
        }
    }

    //批量删除
    public function actionBatchDel(){
        
        $_ids = json_decode($this->post("id",""));
        
        $model = new Role();
        $res = $model->deleteAll(['in', 'id', $_ids]);
  
        if($res){
            return $this->renderJSON([],"批量删除角色成功~~",0);
        }else{
            return $this->renderJSON([],"批量删除角色失败~~",-1);
        }

    }
    
	/**
	 * 处理 数组in 条件
	 */
	public function in_arr($in_arr,$field){
		$in_arr_str= "";
		for($i=0;$i<count($in_arr);$i++){

			$in_arr_str = $in_arr_str."'".$in_arr[$i]."',";
			
		}
		$in_arr_str =rtrim($in_arr_str,",");
		$in_arr_str ="$field in(".$in_arr_str.")"; //减去字符串的最后一个豆号
		
		return $in_arr_str;
	}

 

}