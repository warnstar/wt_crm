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
    public function actionLogin(){

        $get = Yii::$app->request->get();
        $session = Yii::$app->session;
        $session->open();
        if(isset($get['accessUser']) && $get['accessUser'] == "worker"){
            $session->set("accessUser","worker");
        }else{
            $session->set("accessUser","user");
        }

        $code_url  =  (new WeChatAuth())->UserAuthory();
        
        $this->redirect($code_url);
    }


    public function actionGet_user_info(){
        $get = Yii::$app->request->get();
        $post = Yii::$app->request->post();
        dump($get);
        dump($post);
        dump($_SERVER);
    }
    public function actionTest(){
        $auth_url = "http://www.baidu.com";
        header("location:".$auth_url);
        //$this->redirect($auth_url);
    }
}
