<?php
namespace backend\controllers;

use app\models\Area;
use app\models\Brand;
use app\models\Medical_group;
use app\models\Medical_group_user;
use app\models\Note_type;
use app\models\Users;
use app\models\Visit;
use yii\base\ErrorException;
use Yii;
use app\controllers\CommonController;

/**
 * Site controller
 */
class VisitController extends CommonController
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

    //回访列表
    public function  actionVisit_list(){
        $data = [];
        return $this->render("visit_list",$data);
    }


    //待回访列表
    public function actionUn_visit_list(){
        $option['brand_id'] = $this->brand_id;

        $mgu = (new Medical_group_user())->un_visit_users($option);
        $data['mgu'] = $mgu['list'];
        $data['pages'] = $mgu['pages'];


        return $this->render("un_visit_list",$data);
    }

    //回访详情
    public function actionVisit_do(){
        $id = Yii::$app->request->get("id");
        $data['mgu_id'] = $id;
        $data['mgu'] = (new Medical_group_user())->detail($id);

        $data['area'] = [];
        if($data['mgu']){
            $data['area'] = (new Area())->complete_area_name($data['mgu']['area_id']);
        }

        return $this->render("visit_do",$data);
    }

    //回访完成
    public function actionVisit_do_save(){
        $id = Yii::$app->request->post('id');
        $mgu = (new Medical_group_user())->find()->where(['id'=>$id])->one();

        $msg['error'] = 0;
        if($mgu){
            $mgu->last_visit = time();
            $mgu->next_visit = strtotime(date("Y-m-d",time())) + 3600*24*7;
            if($mgu->save()){
                $visit = new Visit();
                $visit->mgu_id = $mgu->id;
                $visit->worker_id = $this->worker_id;
                $visit->create_time = time();
                //创建回访记录
                $visit_res = $visit->create();
                $msg['status'] = 1;
            }else{
                $msg['error'] = "完成访问失败";
            }
        }else{
            $msg['error'] = "该疗程不存在！";
        }

        return json_encode($msg);
    }
    //==>回访异常
    public function actionVisit_error(){
        return $this->render("visit_error");
    }
    //==>回访异常
    public function actionVisit_error_save(){

    }


    //添加备注
    public function actionVisit_note_add(){
        $data['types'] = (new Note_type())->find()->asArray()->all();

        return $this->render("visit_note_add",$data);
    }
    public function actionVisit_note_add_save(){

    }
}
