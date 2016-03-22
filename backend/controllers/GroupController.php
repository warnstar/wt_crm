<?php
namespace backend\controllers;

use common\models\Area;
use common\models\Brand;
use common\models\Medical_group;
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

    function createRandomStr($length){
        $str=array_merge(range(0,9),range('a','z'),range('A','Z'));
        shuffle($str);
        $str=implode('',array_slice($str,0,$length));
        return$str;
    }
}
