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
    public $area_id     = 0;
    public $worker_id   = -1;

    public function beforeAction($event) {

        $auth   = Yii::$app->authManager;
        $isAjax = Yii::$app->request->getIsAjax();
        $session = Yii::$app->session;

        return true;
    }

    /**
     * ==============================测试=====================================
     */
    public function actionTest(){
        echo "test123";
    }
}
