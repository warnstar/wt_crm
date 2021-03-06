<?php
namespace frontend\controllers;

use common\lib\MyHelp;
use common\lib\WeChatAuth;

use yii\helpers\Url;
use common\models\Users;
use common\models\UsersExtra;

use common\models\Worker;
use common\models\WorkerExtra;
use yii;
use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class SiteController extends Controller
{


    public $enableCsrfValidation = false;

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
        $this->redirect(Url::toRoute("site/login"));
    }

    public function actionLogin(){

        $get = Yii::$app->request->get();
        $session = Yii::$app->session;
        $session->open();
        if(isset($get['accessUser']) && $get['accessUser'] == "user"){
            $session->set("accessUser","user");
        }else{
            $session->set("accessUser","worker");
        }
        if((new MyHelp())->isWeChat()){
            /**
             * 当检测到是微信内置浏览器登陆
             */
            (new WeChatAuth())->UserAuthory();
        }else{
            $this->redirect(Url::toRoute("site/get_user_info"));
        }
    }


    public function actionGet_user_info(){
        $get = Yii::$app->request->get();

        $session = Yii::$app->session;
        $session->open();
        $accessUser = $session->get("accessUser");


        $user_info = [];
        //获取到code，再获取用户信息
        if(isset($get['code'])){
            $code = $get['code'];
            $user_info = (new WeChatAuth())->getUserInfo($code);
        }


        if($user_info && $user_info['openid']){
            //授权通过，获得用户信息
            $uid = $user_info['openid'];
            $wechat = $user_info['nickname'];
            if($accessUser == "user"){
                /**
                 * 客户通道
                 **/
                //获取用户第三方绑定信息
                $user = (new UsersExtra())->getUser($uid);

                if($user){
                    //用户已绑定，登陆成功
                    $session->set("user_id",$user->id);
                    $this->redirect(yii\helpers\Url::toRoute("users/detail"));
                }else{
                    //跳转到用户绑定页面
                    $session->set("bind_extra_uid",$uid);
                    $session->set("bind_extra_wechat",$wechat);
                    $this->redirect(Url::toRoute("site/users_bind"));
                }
            }else{
                /**
                 * 职员通道
                 **/
                $worker = (new WorkerExtra())->getUser($uid);

                if($worker){
                    //职员已绑定，登陆成功
                    $session->set("worker_id",$worker->id);
                    $session->set("brand_id",$worker->brand_id);

                    $area_id = (new Worker())->getRangeArea($worker->id);
                    $session->set("area_id",$area_id);

                    $session->set("role_id",$worker->role_id);
                    /**
                     * 跳转
                     */
                    if($worker->role_id == 2){
                        //客服
                        $this->redirect(yii\helpers\Url::toRoute("visit/un_visit_list"));
                    }else if($worker->role_id == 3){
                        //对接人员
                        $this->redirect(yii\helpers\Url::toRoute("visit/error_un_do"));
                    }else{
                        //大区经理
                        $this->redirect(yii\helpers\Url::toRoute("users/search"));
                    }
                }else{
                    //跳转到职员绑定页面
                    $session->set("bind_extra_uid",$uid);
                    $session->set("bind_extra_wechat",$wechat);
                    $this->redirect(Url::toRoute("site/worker_bind"));
                }
            }
        }else{
            //授权失败，跳转到正常手机号登陆页面
            //客户通道

            if($accessUser == "user"){
                $this->redirect(Url::toRoute("site/users_bind"));
            }else{
                //职员通道
                $this->redirect(Url::toRoute("site/worker_bind"));
            }
        }
    }

    /**
     * 用户绑定页面（也可用于普通登陆）
     * @return string
     */
    public function actionUsers_bind(){
        return $this->renderPartial("users_bind");
        
    }
    /**
     * 客户绑定
     * @return mixed
     */
    public function actionUsers_bind_save(){
        $post = Yii::$app->request->post();

        $cases_code = Yii::$app->request->post('cases_code');
        $birth = Yii::$app->request->post('birth');

        //验证用户是否存在
        $birth = strtotime($birth);
        $users_all = (new Users())->find()->where(['cases_code'=>$cases_code])->all();
        $users = null;
        //因时间格式存在时分秒的错乱，需要格式化调整
        if($users_all){
            foreach ($users_all  as $v){
                if(date("Ymd",$v->birth) == date("Ymd",$birth)){
                    $users = $v;
                }
            }
        }

        $msg['status'] = 0;
        if($users){
            //进行绑定
            $session = Yii::$app->session;
            $session->open();
            $bind_extra_uid = $session->get("bind_extra_uid");
            if($bind_extra_uid){
                $extra = (new UsersExtra())->createBind($bind_extra_uid,$users->id);
                if($extra){
                    //绑定成功
                    $users->wechat = $session->get("bind_extra_wechat");
                    $users->save();
                }else{
                    //绑定失败
                }
                unset($session['bind_extra_uid']);
            }else{
                //直接登陆
            }

            //无论无何都是登陆成功
            $msg['status'] = 1;
            $msg['url'] = yii\helpers\Url::toRoute("users/detail");
            $session->set("user_id",$users->id);
        }else{
            $msg['error'] = "用户不存在,请联系客服！";
        }
        return json_encode($msg);
    }

    public function actionWorker_bind(){
        return $this->renderPartial("worker_bind");
    }

    public function actionWorker_bind_save(){
        $post = Yii::$app->request->post();


        $phone = isset($post['phone']) ? $post['phone'] : null;
        $password = isset($post['password']) ? md5($post['password']) : null;

        $res = (new Worker())->WeChatLogin($phone,$password);

        $msg['status'] = 0;
        if($res['code'] == 0){
            $worker = $res['info'];

            $session = Yii::$app->session;
            $bind_extra_uid = $session->get("bind_extra_uid");

            if($bind_extra_uid){
                $extra = (new WorkerExtra())->createBind($bind_extra_uid,$worker->id);
                if($extra){
                    //绑定成功
                    $worker_now = (new Worker())->findOne($worker->id);
                    $worker_now->wechat = $session->get("bind_extra_wechat");
                    $worker_now->save();
                }else{
                    //绑定失败

                }
            }else{
                //直接登陆
            }

            //无论无何都是登陆成功
            $msg['status'] = 1;
            //职员已绑定，登陆成功
            $session->set("worker_id",$worker->id);
            $session->set("brand_id",$worker->brand_id);

            $area_id = (new Worker())->getRangeArea($worker->id);
            $session->set("area_id",$area_id);

            $session->set("role_id",$worker->role_id);


            /**
             * 跳转
             */
            if($worker->role_id == 2){
                //客服
                $msg['url'] = Url::toRoute("visit/un_visit_list");
            }else if($worker->role_id == 3){
                //对接人员
                $msg['url'] = Url::toRoute("visit/error_un_do");
            }else{
                //大区经理
                $msg['url'] = Url::toRoute("users/search");
            }
        }else{
            $msg['error'] = $res['error'];
        }
        return json_encode($msg);
    }

    
    public function actionTest(){
        
    }
}
