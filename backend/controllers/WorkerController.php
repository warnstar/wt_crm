<?php
namespace backend\controllers;



use common\models\Area;
use common\models\Brand;
use common\models\Role;
use common\models\Worker;
use Yii;

/**
 * Site controller
 */
class WorkerController extends CommonController
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
        $res = (new Worker())->search();
        $data['workers'] = $res['list'];
        $data['pages'] = $res['pages'];
        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower();
        $data['roles'] = (new Role())->find()->where("id > 1")->asArray()->all();

        return $this->render('worker_list',$data);
    }

    public function actionList_ajax(){

        $get = Yii::$app->request->get();

        $res = (new Worker())->search($get);
        $data['workers'] = $res['list'];
        $data['pages'] = $res['pages'];

        return $this->renderPartial("worker_list_ajax",$data);
    }

    public function actionDetail(){
        $id = Yii::$app->request->get("id");
        $data['worker'] = (new Worker())->find()->where(['id'=>$id])->asArray()->one();
        $data['brands'] = (new Brand())->search();
        $data['roles'] = (new Role())->find()->where('id > 1')->asArray()->all();

        $area_higher = (new Area())->find()->where(['id'=>$data['worker']['area_id']])->asArray()->one();
        $data['worker']['area_higher_id'] = $area_higher['parent_id'];
        $data['area_higher'] = (new Area())->get_lower(0);
        $data['area_lower'] = (new Area())->get_lower($data['worker']['area_higher_id']);


        return $this->render('worker_detail',$data);
    }

    public function actionAdd(){
        $data['roles'] = (new Role())->find()->where("id > 1")->asArray()->all();
        return $this->render('worker_add',$data);
    }

    public function actionSave(){
        $post = Yii::$app->request->post();
        $worker = new Worker();



        if(isset($post['id']) && $post['id']){
            $worker = (new Worker())->findOne($post['id']);
            if(isset($post['password']) && $post['password']){
                $worker->password = md5($post['password']);
            }
        }else{
            $worker->password = isset($post['password']) ? md5($post['password']) : null;
        }
        $worker->name = isset($post['name']) ? $post['name'] : null;
        $worker->sex = isset($post['sex']) ? $post['sex'] : null;
        $worker->phone = isset($post['phone']) ? $post['phone'] : null;
        $worker->role_id = isset($post['role_id']) ? $post['role_id'] : null;
        $worker->area_id = isset($post['area_id']) ? $post['area_id'] : null;
        $worker->brand_id = isset($post['brand_id']) ? $post['brand_id'] : null;


        if(!$worker->id){
            $worker->create_time = time();
        }
        $msg['status'] = 0;
        $msg['error'] = "操作失败！";
        if($worker->exist()){
            $msg['error'] = "电话号码不能重复！";
        }else{
            if($worker->save()){
                if($worker->role_id == 4){
                    $brand = (new Brand())->find()->where(['id'=>$worker->brand_id])->one();
                    $brand->manager_id = $worker->id;
                    $brand->save();
                }
                $msg['status'] = 1;
            }
        }

        return json_encode($msg);
    }
    public function actionPassword_reset(){
        return $this->render('password_reset');
    }

    public function actionPassword_save(){
        $old_password = Yii::$app->request->post("old_password");
        $new_password = Yii::$app->request->post("new_password");

        $worker = (new Worker())->find()->where(['id'=>$this->worker_id])->one();
        $msg['status'] = 0;
        if(!$worker){
            $msg['error'] = "用户不存在！";
        }
        if(!$old_password || !$new_password){
            $msg['error'] = "新旧密码都不能为空！";
        }

        if(!isset($msg['error'])){
            if(md5($old_password) == $worker->password){
                $worker->password = md5($new_password);
                if($worker->save()){
                    $msg['status'] = 1;
                }else{
                    $msg['error'] = "更新密码失败";
                }
            }else{
                $msg['error'] = "旧密码不对！";
            }
        }
        return json_encode($msg);
    }


}
