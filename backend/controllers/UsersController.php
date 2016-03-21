<?php
namespace backend\controllers;

use app\models\Area;
use app\models\Brand;
use app\models\Medical_group;
use app\models\Users;
use Yii;
use common\models\LoginForm;

/**
 * Site controller
 */
class UsersController extends CommonController
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

    public function actionIndex()
    {
        echo "123";
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function  actionList(){
        $option = [];
        if($this->role_id != 1){
            $option['brand_id'] = $this->brand_id;
        }
        $res = (new Users())->search($option);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];


        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower(0);

        $data['groups'] = [];
        if($this->role_id != 1){
            $data['groups'] = (new Medical_group())->find()->where(['brand_id'=>$this->brand_id])->asArray()->all();
        }


        return $this->render('users_list',$data);
    }
    public function actionList_ajax(){

        $get = Yii::$app->request->get();
        if($this->role_id != 1){
            $get['brand_id'] = $this->brand_id;
        }

        $res = (new Users())->search($get);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];

        return $this->renderPartial("users_list_ajax",$data);
    }
    public function actionDetail(){
        $id = Yii::$app->request->get("id");

        $user = (new Users())->detail($id);
        $data['user'] = $user;

        if($user){
            $data['brands'] = (new Brand())->search();

            $area_higher = (new Area())->find()->where(['id'=>$user['area_id']])->asArray()->one();
            $data['user']['area_higher_id'] = $area_higher['parent_id'];
            $data['area_higher'] = (new Area())->get_lower(0);
            $data['area_lower'] = (new Area())->get_lower($data['user']['area_higher_id']);

            return $this->render('users_detail',$data);
        }else{
            return "未找到用户";
        }
    }

    public function actionAdd(){
        $data['areas'] = (new Area())->get_lower(0);
        $data['brands'] = (new Brand())->search();

        return $this->render('users_add',$data);
    }
    public function actionSave(){
        $post = Yii::$app->request->post();
        $user = new Users();


        if(isset($post['id']) && $post['id']){
            $user = (new Users())->findOne($post['id']);
        }
        $user->name = isset($post['name']) ? $post['name'] : null;
        $user->sex = isset($post['sex']) ? $post['sex'] : null;
        $user->birth = isset($post['birth']) ? strtotime($post['birth']) : null;
        $user->phone = isset($post['phone']) ? $post['phone'] : null;
        $user->passport = isset($post['passport']) ? $post['passport'] : null;
        $user->area_id = isset($post['area_id']) ? $post['area_id'] : null;
        $user->cases_code = isset($post['cases_code']) ? $post['cases_code'] : null;

        //创建的时候
        if(!$user->id){
//            if($this->role_id != 1){
//                $user->brand_id = $this->brand_id;
//            }
            $user->create_time = time();
        }
        $msg['status'] = 0;

        if($user->exist()){
            $msg['error'] = "护照号和病历号不能重复！";
        }else{
            if($user->save()){
                $msg['status'] = 1;
            }else{
                $msg['error'] = "操作失败！";
            }
        }

        return json_encode($msg);
    }
}
