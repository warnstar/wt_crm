<?php
namespace backend\controllers;

use app\models\Area;
use app\models\Brand;
use app\models\Medical_group;
use app\models\Medical_group_user;
use app\models\Note;
use app\models\Note_type;
use app\models\Users;
use yii\base\ErrorException;
use Yii;
use app\controllers\CommonController;

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

        $res = (new Medical_group_user())->search($option);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];

        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower(0);


        return $this->render("group_user_list",$data);
    }

    public function actionDetail(){

    }

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


    public function actionSave(){
        $post = Yii::$app->request->post();
        $mgu = new Medical_group_user();

        if(isset($post['id']) && $post['id']){
            $mgu = (new Medical_group_user())->findOne($post['id']);
        }

        $mgu->medical_group_id = isset($post['group_id']) ? $post['group_id'] : null;
        $mgu->user_id = isset($post['user_id']) ? $post['user_id'] : null;
        $mgu->end_time = isset($post['end_time']) ? (int)$post['end_time']: null;
        if(!$mgu->id){
            $mgu->create_time = time();
        }
        $group = (new Medical_group())->findOne($mgu->medical_group_id);

        $msg['status'] = 0;
        if($group){
            $mgu->start_time = $group->end_time;
            $mgu->end_time = $mgu->start_time + $mgu->end_time * 3600 * 24;//之前保存的结束时间是天，规则是开始后的第几天。

            if($mgu->exist()){
                $msg['error'] = "已经加入该团！";
            }else{
                if($mgu->save()){
                    $msg['status'] = 1;

                    //修改用户最后一次参团与品牌
                    $user = (new Users())->find()->where(['id'=>$mgu->user_id])->one();


                    $user->brand_id = $group->brand_id;
                    $user->last_mgu = $mgu->id;
                    $user->save();
                }
            }
        }else{
            $msg['error'] = "要参加的团不存在！";
        }


        return json_encode($msg);
    }
}
