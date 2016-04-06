<?php
namespace frontend\controllers;

use common\models\Medical_group_user;
use common\models\Note;
use common\models\Users;
use yii;
use yii\web\Controller;
use yii\helpers\Url;
/**
 * Site controller
 */
class OutsourceController extends Controller
{


    //public $enableCsrfValidation = false;

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
    public function actionIndex(){

        return $this->renderPartial("check");
    }

    public function actionCheck_save(){

        $user_name = Yii::$app->request->post('name');
        $passport = Yii::$app->request->post('passport');

        $msg['status'] = 0;
        if($user_name && $passport){
            $users = (new Users())->find()->where(['name'=>$user_name,'passport'=>$passport])->one();
            if($users){
                $msg['status'] = 1;
                $msg['url'] = Url::toRoute("outsource/detail");
                Yii::$app->session->set("outsource_user_id",$users->id);
            }else{
                $msg['error'] = "客户不存在！";
            }
        }else{
            $msg['error'] = "姓名或护照号不能为空！";
        }

        return json_encode($msg);
    }


    public function actionMgu_list(){
        $session = Yii::$app->session;
        $session->open();

        $user_id = $session->get("outsource_user_id");

        if($user_id){
            $option['user_id'] = $user_id;
            $groups = (new Medical_group_user())->search($option,false);
            $data['groups'] = $groups['list'];
            return $this->renderPartial("mgu_list",$data);
        }else{
            return $this->redirect(Url::toRoute("outsource/index"));
        }
    }

    public function actionDetail(){

        $session = Yii::$app->session;
        $session->open();

        $user_id = $session->get("outsource_user_id");

        if($user_id){
            $user = (new Users())->detail($user_id);
            if($user){
                $mgu_id = Yii::$app->request->get("mgu_id");
                //从疗程足迹过来
                if($mgu_id){
                    $data['user'] = (new Medical_group_user())->detail($mgu_id);

                    $data['visit_notes'] = [];
                    if($user['last_mgu']){
                        $option['mgu_id'] = $mgu_id;
                        $option['user_view'] = 1;
                        $data['visit_notes'] = (new Note())->search($option);
                    }

                    return $this->renderPartial("users_detail_more",$data);
                }else{
                    $data['user'] = $user;

                    $data['visit_notes'] = [];
                    if($user['last_mgu']){
                        $option['mgu_id'] = $user['last_mgu'];
                        $option['user_view'] = 1;
                        $data['visit_notes'] = (new Note())->search($option);
                    }
                    return $this->renderPartial("users_detail",$data);
                }

            }else{
                return $this->redirect(Url::toRoute("outsource/index"));
            }
        }else{
            return $this->redirect(Url::toRoute("outsource/index"));
        }
    }
}
