<?php
namespace frontend\controllers;

use common\lib\WeChatAuth;

use common\models\UsersExtra;

use common\models\WorkerExtra;
use yii;
use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class SiteController extends Controller
{

    //w/wt_crm/frontend/web/index.php?r=site/test

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
                        'actions' => ['login','extra_login','test','get_user_info', 'error','logout'],
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

    public function actionExtra_login(){

        $get = Yii::$app->request->get();
        $session = Yii::$app->session;
        $session->open();
        if(isset($get['accessUser']) && $get['accessUser'] == "worker"){
            $session->set("accessUser","worker");
        }else{
            $session->set("accessUser","user");
        }

        (new WeChatAuth())->UserAuthory();
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
            if($accessUser == "user"){
                /**
                 * 客户通道
                 **/
                $user = (new UsersExtra())->getUser($uid);
                if($user){
                    //用户已绑定，登陆成功
                    $session->set("user_id",$user->id);
                    return $this->renderPartial("/users/user_detail");
                }else{
                    //跳转到用户绑定页面
                    $session->set("bind_extra_uid",$uid);
                    return $this->renderPartial("/users/bind");
                }

            }else{
                /**
                 * 职员通道
                 **/
                $user = (new WorkerExtra())->getUser($uid);
                if($user){
                    //职员已绑定，登陆成功
                    $session->set("worker_id",$user->id);
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
                return $this->renderPartial("/users/bind");
            }else{
                //职员通道
            }
        }
    }


    public function actionTest(){
        return $this->renderPartial("/users/bind");
    }
}
