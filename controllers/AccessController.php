<?php

namespace app\controllers;

use app\controllers\common\BaseController;
use app\models\Access;
use app\models\AccessClass;

class AccessController extends  BaseController{


	//权限管理列表
	public function actionIndex(){
       
        if(\Yii::$app->request->isPost){
            
            $limit = $this->post("limit","");
            $page = $this->post("page","");
            $name = $this->post("name","");
            $page = max(1, $page);
            $limit or $limit = 10;
            $offset = ($page - 1) * $limit;

            // 创建一个 DB 查询 角色数据
            $query = Access::find()->alias('a')->select(['a.*','c.class_name as class_name'])->leftJoin('y_access_class c','`a`.`class_id` = `c`.`id`')->orderBy(['a.id'=> SORT_DESC]);
            if($name){
                $query->where(['like', 'a.name',$name]);
            }
            
            // 得到角色数据的总数 
            $count = $query->count();
          
            //分页
            $list = $query->offset($offset)
                ->limit($limit)
                ->asarray()
                ->all();
            return $this->renderJSON($list,"数据列表数据!",0,$count);

        }else{
            $access_class_list = AccessClass::find()->where(['status' => 1])->all();
            return  $this->render("index",compact(
                "access_class_list"
            ));

        }
    }

     
     //处理添加或编辑
     public function actionExecute(){
         
            if(\Yii::$app->request->isGet){
               //TODO 编辑
            }
            $id = trim( $this->post('id',0) );
            $class_id = trim( $this->post('class_id',0) );
            $title = trim( $this->post('title','') );
            $controller = trim( $this->post('controller','') );
            $method = trim( $this->post('method','') );
            $date_now= date("Y-m-d H:i:s");
 
            $info = Access::find()->where(['id'=> $id])->one();
            if( $info ){//如果存在则是编辑
                //TODO...
            }else{//不存在就是添加
                $model_access = new Access();
                $model_access->status = 1;
                $model_access->created_time = $date_now;
            }
    
            $model_access->title = $title;
            $model_access->updated_time = date("Y-m-d H:i:s");
            $model_access->urls = $controller.'/'.$method;
            $model_access->class_id = $class_id;
            
             
             if( $model_access->save(0) ){
                    return $this->renderJSON([],"操作成功~",0);
             }else{
                    return $this->renderJSON([],"操作失败~",-1);
             }
    
      
     
     
        }
    
    	//单条删除
        public function actionMemberDel(){
            
            $id = (int)$this->post("id","");
      
            $Access = Access::find()->where(['id'=>$id])->one(); 

            if($Access->delete()){
                return $this->renderJSON([],"删除成功~~",0);
            }else{
                return $this->renderJSON([],"删除失败~~",-1);
            }
        }

}