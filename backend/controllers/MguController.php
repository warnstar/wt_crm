<?php
namespace backend\controllers;


use common\models\Area;
use common\models\Brand;
use common\models\Medical_group;
use common\models\Medical_group_user;
use common\models\Note;
use common\models\Users;
use Yii;
use yii\helpers\Url;

/**
 * Site controller
 */
class MguController extends CommonController
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
        $medical_group_id = Yii::$app->request->get("medical_group_id");
        $option['medical_group_id'] = $medical_group_id;
        $data['group_id'] = $medical_group_id;

        $res = (new Medical_group_user())->search($option);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];

        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower(0);



        return $this->render("group_user_list",$data);
    }

    public function actionList_ajax(){
        $get = Yii::$app->request->get();


        $res = (new Medical_group_user())->search($get);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];


        return $this->renderPartial("group_user_list_ajax",$data);
    }

    //添加团员
    public function actionAdd(){
        $group_id = Yii::$app->request->get('medical_group_id');
        $data['group_id'] = $group_id;

        $option['un_join_group'] = $group_id;
        $res = (new Users())->search($option);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];

        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower(0);

        return $this->render("group_user_add",$data);
    }
    public function actionAdd_ajax(){
        $get = Yii::$app->request->get();
        $group_id = isset($get['medical_group_id']) ? $get['medical_group_id'] : null;
        $data['group_id'] = $group_id;

        if($group_id){
            $get['un_join_group'] = $group_id;
            unset($get['medical_group_id']);
        }


        $res = (new Users())->search($get);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];

        return $this->renderPartial("group_user_add_ajax",$data);
    }

    /**
     * 创建疗程
     * @return string
     */
    public function actionSave(){
        $post = Yii::$app->request->post();
        $mgu = new Medical_group_user();

        //更新数据的情况
        if(isset($post['id']) && $post['id']){
            $mgu = (new Medical_group_user())->findOne($post['id']);
        }

        $mgu->medical_group_id = isset($post['group_id']) ? $post['group_id'] : null;
        $mgu->user_id = isset($post['user_id']) ? $post['user_id'] : null;
        $mgu->end_time = isset($post['end_time']) ? (int)$post['end_time']: null;
        if(!$mgu->id){
            $mgu->create_time = time();
        }
        $group = (new Medical_group())->find()->where(['id'=>$mgu->medical_group_id])->one();

        $msg['status'] = 0;
        if($group && $mgu->user_id){
            $mgu->start_time = $group->end_time;

            //之前保存的结束时间是天，规则是开始后的第几天。
            $mgu->end_time = $mgu->start_time + $mgu->end_time * 3600 * 24;

            //写入疗程开始后的下次回访时间
            $mgu->next_visit = $mgu->start_time + 3600*24;

            if($mgu->exist()){
                $msg['error'] = "已经加入该团！";
            }else{
                if($mgu->save()){
                    $msg['status'] = 1;

                    //修改用户最后一次参团与品牌
                    $user = (new Users())->find()->where(['id'=>$mgu->user_id])->one();
                    $user->brand_id = $group->brand_id;
                    $user->last_mgu = $mgu->id;
                    $flag['user_mgu'] = $user->save();

                    //修改医疗团用户数
                    $user_count = (new Medical_group_user())->find()->where(['medical_group_id'=>$mgu->medical_group_id])->count("*");
                    $group->user_count = $user_count;
                    $flag['group_count'] = $group->save();
                }
            }
        }else{
            $msg['error'] = "要参加的团或用户不存在！";
        }


        return json_encode($msg);
    }

    //疗程详情
    public function actionMgu_detail(){
        $mgu_id = Yii::$app->request->get("mgu_id");
        $data = [];
        if(!$mgu_id){
            $this->redirect(Url::toRoute("common/home"));
        }else{
            $data['mgu_detail'] = (new Medical_group_user())->detail($mgu_id);

            $option['mgu_id'] = $mgu_id;
            $data['visit_notes'] = (new Note())->search($option);


            return $this->render("mgu_detail",$data);
        }

    }
    //更新疗程信息
    public function actionMgu_update_save(){
        $post = Yii::$app->request->post();
        $mgu = (new Medical_group_user())->find()->where(['id'=>Yii::$app->request->post("mgu_id")])->one();

        $msg['status'] = 0;
        if($post && $mgu){
            if(isset($post['end_time']) && $post['end_time']){
                $mgu->end_time = strtotime(date("Y-m-d",strtotime($post['end_time'])));
            }

            if($mgu->save()){
                $msg['status'] = 1;
            }else{
                $msg['error'] = "更新失败";
            }
        }else{
            $msg['error'] = "请传入正确参数";
        }
        return json_encode($msg);
    }
    //健康足迹
    public function actionUser_join_group(){

        $get = Yii::$app->request->get();
        $option = [];
        if(isset($get['user_id']) && $get['user_id']){
            $option['user_id'] = $get['user_id'];
        }
        if(isset($get['brand_id']) && $get['brand_id']){
            $option['brand_id'] = $get['brand_id'];
        }

        $groups = (new Medical_group_user())->search($option);
        $data['groups'] = $groups['list'];
        $data['pages'] = $groups['pages'];


        return $this->render("user_join_group",$data);
    }

    public function actionDelete(){
        $id = Yii::$app->request->post("id");

        $msg['status'] = 0;

        $res = (new Medical_group_user())->delete_this($id);
        if(isset($res['code']) && $res['code'] == 0){
            $msg['status'] = 1;

        }else{
            $msg['error'] = $res['error'];
        }

        return json_encode($msg);
    }
}
