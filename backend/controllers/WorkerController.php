<?php
namespace backend\controllers;

use app\controllers\CommonController;
use app\models\Area;
use app\models\Brand;
use app\models\Worker;
use Yii;
use yii\filters\AccessControl;
use yii\rbac\Role;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

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
        $data['roles'] = (new \app\models\Role())->find()->where("id > 1")->asArray()->all();

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
        $data['roles'] = (new \app\models\Role())->find()->where('id > 1')->asArray()->all();

        $area_higher = (new Area())->find()->where(['id'=>$data['worker']['area_id']])->asArray()->one();
        $data['worker']['area_higher_id'] = $area_higher['parent_id'];
        $data['area_higher'] = (new Area())->get_lower(0);
        $data['area_lower'] = (new Area())->get_lower($data['worker']['area_higher_id']);


        return $this->render('worker_detail',$data);
    }

    public function actionAdd(){
        $data['roles'] = (new \app\models\Role())->find()->where("id > 1")->asArray()->all();
        return $this->render('worker_add',$data);
    }

    public function actionSave(){
        $post = Yii::$app->request->post();
        $worker = new Worker();



        if(isset($post['id']) && $post['id']){
            $worker = (new Worker())->findOne($post['id']);
        }
        $worker->name = isset($post['name']) ? $post['name'] : null;
        $worker->sex = isset($post['sex']) ? $post['sex'] : null;
        $worker->phone = isset($post['phone']) ? $post['phone'] : null;
        $worker->role_id = isset($post['role_id']) ? $post['role_id'] : null;
        $worker->area_id = isset($post['area_id']) ? $post['area_id'] : null;
        $worker->brand_id = isset($post['brand_id']) ? $post['brand_id'] : null;
        $worker->password = isset($post['password']) ? md5($post['password']) : null;

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
    public function password_reset(){
        return $this->render('password_reset',$data);
    }
}
