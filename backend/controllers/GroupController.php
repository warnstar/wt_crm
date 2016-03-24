<?php
namespace backend\controllers;

use common\Excel;
use common\models\Area;
use common\models\Brand;
use common\models\Medical_group;
use common\models\Medical_group_user;
use common\models\Users;
use Yii;

/**
 * Site controller
 */
class GroupController extends CommonController
{


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function  actionList(){
        $option = [];
        if($this->role_id != 1){
            $option['brand_id'] = $this->brand_id;
        }

        $data['brands'] = (new Brand())->search();
        $res = (new Medical_group())->search($option);
        $data['groups'] = $res['list'];
        $data['pages'] = $res['pages'];

        return $this->render('group_list',$data);
    }

    public function actionList_ajax(){
        $get = Yii::$app->request->get();
        if($this->role_id != 1){
            $get['brand_id'] = $this->brand_id;
        }

        $res = (new Medical_group())->search($get);
        $data['groups'] = $res['list'];
        $data['pages'] = $res['pages'];

        return $this->renderPartial("group_list_ajax",$data);
    }

    public function actionDetail(){
        $id = Yii::$app->request->get('id');

        $data['brands'] = (new Brand())->search();

        $group = (new Medical_group())->detail($id);
        $data['group'] = $group;
        if($group){

            return $this->render('group_detail',$data);
        }else{
            exit("无详情！");
        }

    }

    public function actionAdd(){

        $rand_code  = date("Ymd",time()) . $this->createRandomStr(3);
        while((new Medical_group())->find()->where(['group_code'=>$rand_code])->one()){
            $rand_code  = date("Ymd",time()) . $this->createRandomStr(3);
        }

        $data['rand_code'] = $rand_code;
        $data['brands'] = (new Brand())->search();

        return $this->render('group_add',$data);
    }

    public function actionSave(){
        $post = Yii::$app->request->post();
        $group = new Medical_group();

        if(isset($post['id']) && $post['id']){
            $group = (new Medical_group())->findOne($post['id']);
        }

        $group->group_code = isset($post['group_code']) ? $post['group_code'] : null;
        $group->name = isset($post['name']) ? $post['name'] : null;
        $group->brand_id = isset($post['brand_id']) ? $post['brand_id'] : null;
        $group->start_time = isset($post['start_time']) ? strtotime($post['start_time']) : null;
        $group->end_time = isset($post['end_time']) ? strtotime($post['end_time']) : null;
        if(!$group->id){
            $group->create_time = time();
        }
        $msg['status'] = 0;
        $msg['error'] = "操作失败！";

        $res = $group->check();

        if($res['code'] == 0){
            if($group->exist()){
                $msg['error'] = "团编号不能重复！";
            }else{
                if($group->save()){
                    $msg['status'] = 1;
                }
            }
        }else{
            $msg['error'] = $res['error'];
        }



        return json_encode($msg);
    }

    public function actionUser_add(){
        $group_id = Yii::$app->request->get('id');
        $data['group_id'] = $group_id;

        $option['un_join_group'] = $group_id;
        $res = (new Users())->search($option);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];

        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower(0);

        return $this->render("group_user_add",$data);
    }

    public function actionGroup_select(){
        $get = Yii::$app->request->get();

        $option = [];
        if(isset($get['brand_id']) && $get['brand_id'] >= 0){
            $option['brand_id'] = (int)$get['brand_id'];
        }

        $data['groups'] = (new Medical_group())->find()->where(['brand_id'=>$option['brand_id']])->asArray()->all();

        return $this->renderPartial("group_select",$data);
    }

    //创建随机字符串
    function createRandomStr($length){
        $str=array_merge(range(0,9),range('a','z'),range('A','Z'));
        shuffle($str);
        $str=implode('',array_slice($str,0,$length));
        return$str;
    }

    /**
     * 导出excel
     */
    public function actionGroup_user_export()
    {
        $id = Yii::$app->request->get('id');
        if($id){
            $res = (new Medical_group_user())->excel_data($id);

            if($res){
                if(isset($res['excel_title']) && isset($res['excel_data']) && isset($res['excel_name'])){
                    (new Excel())->export_data($res['excel_data'],$res['excel_title'],$res['excel_name']);
                }
            }
        }else{
            echo "group_id不对！";
        }
    }

    /**
     * 导入数据
     */
    public function actionGroup_user_import(){
        $group_id = Yii::$app->request->post("group_id");

        $user_data = (new Excel())->import_data();

        //初步过滤
        $user_data = $this->excel_user_filter($user_data,$group_id);


        $new_users = [];
        $join_users = [];
        if($user_data){
            $user_data = $this->get_exist_users($user_data,$group_id);

            foreach($user_data as $k=>$v){
                if($v['flag'] == 1){
                    //已存在但未参与的用户
                    $mgu['group_id'] = $group_id;
                    $mgu['user_id'] = $v['user_id'];
                    $mgu['end_time'] = 10;

                    $mgu_new = (new Medical_group_user())->create($mgu);
                    if($mgu_new){
                        $join_users[] = $mgu_new;
                    }


                }else if($v['flag'] == 3){
                    //不存在且正常的用户
                    $res_new = (new Users())->create_data($v);
                    if($res_new){
                        $new_users[] = $res_new;
                        $mgu['group_id'] = $group_id;
                        $mgu['user_id'] = $v['user_id'];
                        $mgu['end_time'] = 10;

                        $mgu_new = (new Medical_group_user())->create($mgu);
                        if($mgu_new){
                            $join_users[] = $mgu_new;
                        }
                    }
                }
            }

        }


        //处理返回结果
        $msg['status'] = 0;
        if($join_users){

            foreach($join_users as $k=>$v){
                $area = (new Area())->find()->where(['id'=>$v['area_id']])->asArray()->one();
                if($area){
                    $join_users[$k]['area_name'] = $area['name'];
                }else{
                    $join_users[$k]['area_name'] = "";
                }

                $brand = (new Brand())->find()->where(['id'=>$v['brand_id']])->asArray()->one();
                if($brand){
                    $join_users[$k]['brand_name'] = $brand['name'];
                }else{
                    $join_users[$k]['brand_name'] = "";
                }

            }

            $msg['status'] = 1;

            $session = Yii::$app->session;
            $session->set("users",$join_users);

        }
        return json_encode($msg);
    }

    public function actionExcel_import_result()
    {
        $session = Yii::$app->session;

        $data['users'] = $session->get("users");

        return $this->render("excel_import_result",$data);
    }

    //初步过滤
    function excel_user_filter($users = [],$group_id = 0){
        // “	姓名	 性别	手机号	护照号	出生年月（mm/dd/YY)	HN	品牌	 所属区域  ”
        //不能为空：姓名，性别，手机号，护照号，HN,所属区域
        //不能重复：护照号，HN
        //品牌为无效字段，由所参加的团的品牌决定
        //以护照号为用户标准，
        //$users['flag'] = (0=非法；1=已存在用户；2=已参加,3=正常）


        $keys = ['name','sex','phone','passport','birth','cases_code','brand','area_id'];
        $error_data = [];
        if($users){
            $data = [];

            array_shift($users);//去掉首行的表头

            //设置键值
            foreach($users as $k=>$v){
                $i = 0;
                foreach($v as $kk=>$vv){
                    $data[$k][$keys[$i]] = $vv;
                    $i = $i + 1;
                }

            }
            $users = $data;

            //转换部分数据格式
            foreach($users as $k=>$v){
                //去掉名字为空的
                if(!$v['name']){
                    $users[$k]['flag'] = 0 ;
                }

                //性别转换
                if($v['sex'] == "男"){
                    $users[$k]['sex'] = 1;
                }else{
                    $users[$k]['sex'] = 2;
                }

                //去掉电话为空的
                if(!$v['phone']){
                    $users[$k]['flag'] = 0 ;
                }

                //去掉护照为空的
                if(!$v['passport']){
                    $users[$k]['flag'] = 0 ;
                }

                //去掉病历号为空的
                if(!$v['cases_code']){
                    $users[$k]['flag'] = 0 ;
                }

                //生日转换
                if($v['birth']){
                    $users[$k]['birth'] = strtotime($v['birth']);
                }else{
                    $users[$k]['flag'] = 0 ;
                }

                //获取品牌id
                $brand = (new Medical_group())->find()->where(['id'=>$group_id])->asArray()->one();
                $users[$k]['brand_id'] = $brand['id'];

                //区域转换
                $area_name = $v['area_id'];
                $area = (new Area())->find()->where(['like', 'name', $area_name])->andWhere("parent_id != 0")->asArray()->one();
                if($area && $area['name']){
                    $users[$k]['area_id'] = $area['id'];
                }else{
                    $error_data[] = $v;
                    $users[$k]['flag'] = 0 ;
                }
            }
        }else{
            return null;
        }
        return $users;
    }

    //筛选出已存在的用户(护照号)
    public function get_exist_users($users = [],$group_id){

        if($users){
            foreach($users as $k=>$v){
                $u = (new Users())->find()->where(['passport'=>$v['passport']])->asArray()->one();
                if($u){

                    $mgu = (new Medical_group_user())->find()->where(['user_id'=>$u['id'],'medical_group_id'=>$group_id])->asArray()->one();
                    if($mgu){
                        //已加入该团
                        $users[$k]['flag'] = 2;
                    }else{
                        //用户存在但未加团
                        $users[$k]['flag'] = 1;
                    }

                    $users[$k]['user_id'] = $u['id'];
                }else{
                    $users[$k]['user_id'] = 0;
                    $users[$k]['flag'] = 3;
                }
            }
            return $users;
        }else{
            return null;
        }
    }

    public function actionDelete(){
        $id = Yii::$app->request->post("id");

        $msg['status'] = 0;

        $res = (new Medical_group())->delete_this($id);
        if(isset($res['code']) && $res['code'] == 0){
            $msg['status'] = 1;
        }else{
            $msg['error'] = $res['error'];
        }

        return json_encode($msg);
    }
}
