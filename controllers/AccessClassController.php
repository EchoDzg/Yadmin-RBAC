<?php

namespace app\controllers;

use app\controllers\common\BaseController;
use app\models\AccessClass;
use app\models\Access;
use yii\validators\RequiredValidator;

class AccessClassController extends  BaseController{


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
            $query = AccessClass::find()->orderBy(['id'=> SORT_DESC]);
            if($name){
                $query->where(['like', 'name',$name]);
            }
            
            // 得到角色数据的总数 
            $count = $query->count();
          
            // 分页
            $list = $query->offset($offset)
                ->limit($limit)
                ->asarray()
                ->all();

            return $this->renderJSON($list,"数据列表数据!",0,$count);

        }else{
            
            return  $this->render("index");

        }
    }

     
    //处理添加或编辑
    public function actionExecute(){
         
        if(\Yii::$app->request->isGet){
       
            $id = $this->get('id',0);
            $info = [];

            if( $id ){
                
                $info = AccessClass::find()->where(['status' => 1,'id'=> $id])->one();

            }
            
            return  $this->render("execute",compact('info'));
        
        }
        $id = trim( $this->post('id',0) );
        $name = trim( $this->post('name',0) );

         
        $date_now= date("Y-m-d H:i:s");

        //查询是否已经存在
        if(AccessClass::find()->where(['class_name' => $name])->andWhere([ '!=','id',$id ])->count() ){
            return $this->renderJSON([],"分类名已经存在~",-1);
        }

        
        $info = AccessClass::find()->where(['id'=> $id])->one();
        if( $info ){//如果存在则是编辑
            $model_access_class = $info;
        }else{//不存在就是添加
            $model_access_class = new AccessClass();
            $model_access_class->status = 1;
            $model_access_class->created_time = $date_now;
        }

        $model_access_class->class_name = $name;
        $model_access_class->updated_time = date("Y-m-d H:i:s");


        
         
         if( $model_access_class->save(0) ){
                return $this->renderJSON([],"操作成功~",0);
         }else{
                return $this->renderJSON([],"操作失败~",-1);
         }

  
 
 
    }

	//单条删除
	public function actionDel(){
        
        $id = (int)$this->post("id","");
 
        $AccessClass = AccessClass::find()->where(['id'=>$id])->one(); 

        if($AccessClass->delete()){
            Access::deleteAll('class_id='.$AccessClass->id);
            return $this->renderJSON([],"删除成功~~",0);
        }else{
            return $this->renderJSON([],"删除失败~~",-1);
        }
    }


}