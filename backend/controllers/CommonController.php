<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\filters\AccessControl;
/**
 * @desc   公共控制器，需要权限验证的都继承此控制器
 * @author WCHUANG
 * @date   2016-1-12
 */
class CommonController extends Controller {

    public $enableCsrfValidation = false;

    //当前登录用户的权限属性
    public $role_id     = 0;
    public $brand_id    = 0;
    public $area_id     = 0;

    public function beforeAction($event) {

        $auth   = Yii::$app->authManager;
        $isAjax = Yii::$app->request->getIsAjax();
        $session = Yii::$app->session;
        $worker = $session->get('worker');

        //已登陆
        if ($worker && $worker['role_id'] > 0 && $worker['role_id'] < 4 && $worker['id'] >= -1) {
            //设置当前登录用户的权限属性
            $this->role_id      = $worker['role_id'];
            $this->brand_id     = $worker['brand_id'];
            $this->area_id      = $worker['area_id'];

            return true;
        }else{
            $this->goHome();
        }
    }

    protected function renderJson($params = []) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $params;
    }

    public function errorshow($error = ''){
        return $this->renderPartial('//site/error',['error' => $error]);
    }


}
