<?php
namespace backend\controllers;


use common\models\Area;
use common\models\Brand;
use common\models\Medical_group;
use common\models\Medical_group_user;
use common\models\Note;
use common\models\Note_type;
use common\models\SysSms;
use common\models\Visit;
use common\models\Worker;
use Yii;

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
        $get = Yii::$app->request->get();
        $option = [];
        if($this->worker_id){
            //$option['worker_id'] = $this->worker_id;
        }
        if(isset($get['mgu_id']) && $get['mgu_id']){
            $option['mgu_id'] = $get['mgu_id'];
        }

        $visits = (new Visit())->search($option);

        $data['visits'] = $visits['list'];
        $data['pages'] = $visits['pages'];

        return $this->render("visit_list",$data);
    }

    //回访详情
    public function actionVisit_detail(){
        $id = Yii::$app->request->get("id");
        $data['visit'] = (new Visit())->detail($id);

        $option['visit_id'] = $id;
        $data['visit_notes'] = (new Note())->search($option);


        return $this->render("visit_detail",$data);
    }

    //待回访列表
    public function actionUn_visit_list(){
        $option = [];
        if($this->role_id != 1){
            $option['brand_id'] = $this->brand_id;
        }
        $res = (new Medical_group_user())->un_visit_users($option);
        $data['mgu'] = $res['list'];
        $data['pages'] = $res['pages'];


        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower(0);

        $data['groups'] = [];
        if($this->role_id != 1){
            $data['groups'] = (new Medical_group())->find()->where(['brand_id'=>$this->brand_id])->asArray()->all();
        }

        return $this->render("un_visit_list",$data);
    }
    public function actionUn_visit_list_ajax(){

        $get = Yii::$app->request->get();
        if($this->role_id != 1){
            $get['brand_id'] = $this->brand_id;
        }

        $res = (new Medical_group_user())->un_visit_users($get);
        $data['mgu'] = $res['list'];
        $data['pages'] = $res['pages'];

        return $this->renderPartial("un_visit_list_ajax",$data);
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
        $mgu_id = Yii::$app->request->get("mgu_id");
        $mgu = (new Medical_group_user())->find()->where(['id'=>$mgu_id])->one();
        if($mgu){
            $data['mgu_id'] = $mgu_id;

            return $this->render("visit_error",$data);
        }else{
            return "访问异常";
        }
    }
    //==>回访异常
    public function actionVisit_error_save(){
        $post = Yii::$app->request->post();

        $next_day = isset($post['next_day']) ? $post['next_day'] : null;
        $notify_user = isset($post['notify_user']) ? $post['notify_user'] : null;

        $note = new Note();

        $note->mgu_id = isset($post['mgu_id']) ? $post['mgu_id'] : null;
        $note->content =  isset($post['content']) ? $post['content'] : null;
        $note->general_note_type = 0;
        $note->content_type = 1;//异常备注只有文本
        $note->type = 2;        //异常备注
        $note->worker_id = $this->worker_id;
        $note->notify_user = $notify_user;
        $note->create_time = time();

        $mgu = (new Medical_group_user())->find()->where(['id'=>$note->mgu_id])->one();

        $msg['status'] = 0;

        //创建备注成功
        if($mgu && $note->save()){
            $msg['status'] = 1;

            //完成回访
            $mgu->last_visit = time();
            if($next_day == 1){
                //第二天通知我
                $mgu->next_visit = strtotime(date("Y-m-d",time())) + 3600*24*1;
            }else{
                $mgu->next_visit = strtotime(date("Y-m-d",time())) + 3600*24*7;
            }

            //回访时间设置完成
            if($mgu->save()){
                //创建回访记录
                $visit = new Visit();
                $visit->notify_user = $notify_user;//通知用户
                $visit->mgu_id = $mgu->id;
                $visit->worker_id = $this->worker_id;
                $visit->type = 2;//异常回访
                $visit->error_content = $note->content;//异常备注
                $visit->create_time = $mgu->last_visit;
                //创建回访记录
                $visit_res = $visit->create();
                if($visit_res){
                    //发送短信通知
                    $workers  = (new Worker())->getRoleWorker($notify_user,$mgu->id);
                    if($workers) foreach($workers as $v){
                        $res = (new SysSms())->error_notice($v['phone'],$mgu->user_id);

                    }
                }

            }else{
                $msg['error'] = "创建回访记录失败！";
            }
        }else{
            $msg['error'] = "创建备注失败";
        }

        return json_encode($msg);
    }


    //添加备注
    public function actionVisit_note_add(){
        $mgu_id = Yii::$app->request->get("mgu_id");
        if($mgu_id){
            $data['types'] = (new Note_type())->find()->asArray()->all();
            $data['mgu_id'] = $mgu_id;

            //异常备注
            $data['type'] = Yii::$app->request->get('type');
            $data['visit_id'] = Yii::$app->request->get('visit_id');

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
        $type = (isset($post['type']) && $post['type'])  ? $post['type'] : 1;//是否为异常备注

        $note = new Note();

        $note->visit_id = (isset($post['visit_id']) && $post['visit_id']) ? $post['visit_id'] : 0;
        $note->mgu_id = isset($post['mgu_id']) ? $post['mgu_id'] : null;
        $note->general_note_type = isset($post['general_note_type']) ? $post['general_note_type'] : 0;
        $note->content_type = isset($post['content_type']) ? $post['content_type'] : null;
        $note->user_view = (isset($post['user_view']) && $post['user_view']) ? $post['user_view'] : 0;
        $note->type = $type;//普通/异常备注
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


    //列出异常备注
    public function actionError_un_do(){
        $option = [];
        if($this->role_id != 1){
            $option['brand_id'] = $this->brand_id;
        }
        $res = (new Visit())->undo_error_users($option);
        $data['list'] = $res['list'];
        $data['pages'] = $res['pages'];

        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower(0);

        $data['groups'] = [];
        if($this->role_id != 1){
            $data['groups'] = (new Medical_group())->find()->where(['brand_id'=>$this->brand_id])->asArray()->all();
        }


        return $this->render("error_un_do",$data);
    }
    public function actionError_un_do_ajax(){
        $get = Yii::$app->request->get();
        if($this->role_id != 1){
            $get['brand_id'] = $this->brand_id;
        }

        $res = (new Visit())->undo_error_users($get);
        $data['list'] = $res['list'];
        $data['pages'] = $res['pages'];

        return $this->renderPartial("error_un_do_ajax",$data);
    }

    //处理问题
    public function actionError_do(){
        $visit_id = Yii::$app->request->get("visit_id");

        $data['detail'] = (new Visit())->detail($visit_id);


        return $this->render("error_do",$data);
    }


    //处理完成
    public function actionError_do_save(){
        $visit_id = Yii::$app->request->post('visit_id');
        $visit = (new Visit())->find()->where(['id'=>$visit_id])->one();

        $msg['error'] = 0;
        if($visit){
            $visit->type_status = 1;
            $visit->error_end_time = time();
            if($visit->save()){
                $msg['status'] = 1;
            }else{
                $msg['error'] = "处理完成失败";
            }
        }else{
            $msg['error'] = "该回访记录不存在！";
        }

        return json_encode($msg);
    }


    public function actionError_had_do(){
        $res = (new Visit())->had_do_error_users();
        $data['list'] = $res['list'];
        $data['pages'] = $res['pages'];


        return $this->render("error_had_do",$data);
    }
}
