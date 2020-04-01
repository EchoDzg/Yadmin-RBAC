<?php
namespace app\services;
use Yii;
use app\models\RoleAccess;
use app\models\AccessClass;
use app\models\Access;
class MenuService
{
    
    private static function Menu()
    {
        return [
            [// 0 
                'name' => '系统管理',
                'is_menu' => true,
                'route' => '',
                'icon' => '&#xe726;',
                'children' => [
                    [
                        'name' => '管理员列表',
                        'is_menu' => true,
                        'icon' => '&#xe6a7;',
                        'route' => '/user/index',
                    ],
                    [
                        'name' => '角色管理',
                        'is_menu' => true,
                        'icon' => '&#xe6a7;',
                        'route' => '/role/home',
                    ],
                    [
                        'name' => '权限分类',
                        'is_menu' => true,          
                        'icon' => '&#xe6a7;',
                        'route' => '/access-class/index',
                    ],
                    [
                        'name' => '权限节点',
                        'is_menu' => true,          
                        'icon' => '&#xe6a7;',
                        'route' => '/access/index',
                    ]
   
                ],
            ]

        ];
    }

    //获取菜单数据
    public static function getMenu(){
        
        //获取用户id
        $uid = self::get_uid();
        $MenuData = self::Menu();

        /*
        //if($uid != 1){ //非总管理员
                //TODO 过滤无权限菜单...
                $access_ids = RoleAccess::find()->where([ 'role_id' =>  $uid ])->select('urls')->asArray()->column();
                $work = 0 ;
                foreach($MenuData as $k=>$v){
                    if(!empty($v['children'])){
                        foreach($v['children'] as $c_k=>$c_v){
                            //校验权限
                            foreach($access_ids as $k_v=>$v_v){
                                    if($c_v['route']==$v_v){
                                    $work = 1;
                                    }
                            }
                            if(!$work){
                                    unset($MenuData[$k]['children'][$c_k]);
                            }
                            $work = 0;
                        }
                    }
                }
                //剔除空菜单
                foreach($MenuData as $k=>$v){
                    if(empty($v['children'])){
                        unset($MenuData[$k]);
                    }
                }
        //}

        */
        //var_dump(json_encode($MenuData));die;
        return $MenuData;
        
    }

    //获取权限路由节点
    public static function getPermissionNode(){

        $access_class_list = AccessClass::find()->where(['status' => 1])->asarray()->all();
        $access_list = Access::find()->where(['status' => 1])->asarray()->all();
        foreach ($access_class_list as $k=>$v){

            
            foreach($access_list as $val){

                if(($val['class_id']) == ($v['id'])){

                    $access_class_list[$k]['data'][] = $val;
       
                }

            }

        }
 
     
        return $access_class_list;
        
    }


    //获取用户id
    public static function get_uid(){

            $request = Yii::$app->request;
            $cookies = $request->cookies;
            $auth_cookie = $cookies->get('imguowei_888');
            if(!$auth_cookie){
                return false;
            }
            list($auth_token,$uid) = explode("#",$auth_cookie);

            if(!$auth_token || !$uid){
                return false;
            }
            return $uid;

    }
}
