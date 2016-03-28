<?php
namespace frontend\controllers;

use common\lib\WeChatAuth;
use common\models\Users;
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
                        'actions' => ['login','test','get_user_info', 'error','logout'],
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

        $user_info = [];
        if(isset($get['code'])){
            $code = $get['code'];
            $user_info = (new WeChatAuth())->getUserInfo($code);
        }

        dump($user_info);

    }
    public function actionTest(){
        $auth_url = "http://www.baidu.com";
        header("location:".$auth_url);
        //$this->redirect($auth_url);
    }
}
