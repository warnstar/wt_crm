<?php
namespace frontend\controllers;


use Yii;
use yii\web\Controller;

/**
 * @desc   公共控制器，需要权限验证的都继承此控制器
 * @author WCHUANG
 * @date   2016-3-27
 */
class CommonController extends Controller {

    public $enableCsrfValidation = false;

    //当前登录用户的权限属性
    public $role_id     = 0;
    public $brand_id    = 0;
    public $area_id     = null;
    public $worker_id   = null;
    public $user_id     = null;
    public $accessUser = null;

    public function beforeAction($event) {

        $auth   = Yii::$app->authManager;
        $isAjax = Yii::$app->request->getIsAjax();
        $session = Yii::$app->session;
        $session->open();


        $this->accessUser = $session->get("accessUser");
        if($this->accessUser == "worker"){
            //职员通道
            $worker_id = $session->get("worker_id");
            $role_id = $session->get("role_id");
            $area_id = $session->get("area_id");
            $brand_id = $session->get("brand_id");

            if($worker_id && $role_id && $brand_id){
                $this->brand_id = $brand_id;
                $this->role_id = $role_id;
                $this->area_id = $area_id;
                $this->worker_id = $worker_id;
                return true;
            }
        }else if($this->accessUser == "user"){
            //客户通道
            $user_id = $session->get("user_id");
            
            if($user_id){
                $this->user_id = $user_id;
                return true;
            }
        }
        return $this->goHome();
    }

    
}
