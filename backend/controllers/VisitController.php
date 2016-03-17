<?php
namespace backend\controllers;

use app\models\Area;
use app\models\Medical_group_user;
use app\models\Note;
use app\models\Note_type;
use app\models\Visit;
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
        $get = Yii::$app->request->get("mgu_id");
        $option = [];
        if($this->worker_id){
            $option['worker_id'] = $this->worker_id;
        }
        if(isset($get['mgu_id']) && $get['mgu_id']){
            $option['mgu_id'] = $get['mgu_id'];
        }

        $visits = (new Visit())->search($option);

        $data['visits'] = $visits['list'];
        $data['pages'] = $visits['pages'];

        return $this->render("visit_list",$data);
    }

    public function actionVisit_detail(){
        $id = Yii::$app->request->get("id");
        $data['visit'] = (new Visit())->detail($id);

        $option['visit_id'] = $id;
        $data['visit_notes'] = (new Note())->search($option);


        return $this->render("visit_detail",$data);
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
                $visit->create_time = $mgu->last_visit;
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
        $mgu_id = Yii::$app->request->get("mgu_id");
        if($mgu_id){
            $data['types'] = (new Note_type())->find()->asArray()->all();
            $data['mgu_id'] = $mgu_id;

            return $this->render("visit_note_add",$data);
        }else{
            return "疗程错误！";
        }

    }

    /**
     * 创建备注（普通备注）
     * @return string
     * @throws \Exception
     */
    public function actionVisit_note_save(){
        $post = Yii::$app->request->post();
        $note = new Note();

        $note->mgu_id = isset($post['mgu_id']) ? $post['mgu_id'] : null;
        $note->general_note_type = isset($post['general_note_type']) ? $post['general_note_type'] : 0;
        $note->content_type = isset($post['content_type']) ? $post['content_type'] : null;
        $note->type = 1;//普通备注
        $note->worker_id = $this->worker_id;
        $note->create_time = time();

        $msg['status'] = 0;

        if($note->save()){

            //存储备注内容--上传文件
            if($note->content_type == 1){
                //存入文字
                $note->content = isset($post['content_text']) ? $post['content_text'] : null;
                $note->save();
            }else if($note->content_type == 2 || $note->content_type == 3 ){
                //存入文件（可多文件）
                if($_FILES){
                    $res_url = [];
                    foreach($_FILES as $name=>$v){
                        $res_url[] = (new \common\lib\oss\Oss())->file_upload($name);
                    }
                    if($res_url){
                        $note->content = json_encode($res_url);
                    }

                }
            }

            //存储备注内容
            if($note->content){
                if($note->save()){
                    $msg['status'] = 1;
                }else{
                    $note->delete();
                    $msg['error'] = "备注资料上传失败";
                }
            }else{
                $note->delete();
                $msg['error'] = "备注资料上传失败";
            }
        }else{
            $msg['error'] = "创建备注失败";
        }

        return json_encode($msg);
    }
}
