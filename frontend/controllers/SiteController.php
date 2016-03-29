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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','extra_login','test','get_user_info','users_bind_save','users_bind', 'error','logout'],
                        'allow' => true,
                    ]
                ],
            ],
        ];
    }
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
        echo "123";
    }

    public function actionLogin(){

        $get = Yii::$app->request->get();
        $session = Yii::$app->session;
        $session->open();
        if(isset($get['accessUser']) && $get['accessUser'] == "worker"){
            $session->set("accessUser","worker");
        }else{
            $session->set("accessUser","user");
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
                    $session->set("access_type",0);//客户
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

                    $area_id = (new Worker())->getRangeArea();
                    $session->set("area_id",$area_id);

                    $session->set("role_id",$worker->role_id);
                    $session->set("access_type",1);//职员
                    if($worker->role_id == 2){
                        //客服

                    }else if($worker->role_id == 3){
                        //对接人员

                    }else{
                        //大区经理

                    }
                }else{
                    //跳转到职员绑定页面
                    $session->set("bind_extra_uid",$uid);
                    return $this->renderPartial("/worker/bind");
                }
            }
        }else{
            //授权失败，跳转到正常手机号登陆页面
            //客户通道
            if($accessUser == "user"){
                $this->redirect(Url::toRoute("site/users_bind"));
            }else{
                //职员通道
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

        $passport = isset($post['passport']) ? $post['passport'] : null;
        $name = isset($post['name']) ? $post['name'] : null;

        //验证用户是否存在
        $user = (new Users())->find()->where(['passport'=>$passport,'name'=>$name])->one();
        $msg['status'] = 0;
        if($user){
            //进行绑定
            $session = Yii::$app->session;
            $session->open();
            $bind_extra_uid = $session->get("bind_extra_uid");
            if($bind_extra_uid){
                $extra = (new UsersExtra())->createBind($bind_extra_uid,$user->id);
                if($extra){
                    //绑定成功
                    $user->wechat = $session->get("bind_extra_wechat");
                    $user->save();
                }else{
                    //绑定失败
                }
            }else{
                //直接登陆
            }

            //无论无何都是登陆成功
            $msg['status'] = 1;
            $msg['url'] = yii\helpers\Url::toRoute("users/detail");
            $session->set("user_id",$user->id);
            $session->set("access_type",0);//客户
        }else{
            $msg['error'] = "用户不存在,请联系客服！";
        }
        return json_encode($msg);
    }

    public function actionTest(){
        $this->goHome();
    }
}
