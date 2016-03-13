<?php
namespace backend\controllers;

use app\models\Area;
use app\models\Brand;
use app\models\Users;
use Yii;
use app\controllers\CommonController;
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

        $res = (new Users())->search();
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];

        $data['brands'] = (new Brand())->search();
        $data['areas'] = (new Area())->get_lower(0);

        return $this->render('users_list',$data);
    }
    public function actionList_ajax(){

        $get = Yii::$app->request->get();

        $res = (new Users())->search($get);
        $data['users'] = $res['list'];
        $data['pages'] = $res['pages'];

        return $this->renderPartial("users_list_ajax",$data);
    }
    public function actionDetail(){
        return $this->render('users_detail');
    }

    public function actionAdd(){
        $data['areas'] = (new Area())->get_lower(0);

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


        if(!$user->id){
            $user->create_time = time();
        }
        $msg['status'] = 0;
        $msg['error'] = "操作失败！";
        if($user->exist()){
            $msg['error'] = "护照号和病历号5不能重复！";
        }else{
            if($user->save()){

                $msg['status'] = 1;
            }
        }

        return json_encode($msg);
    }
}
