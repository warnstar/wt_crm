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

    public function beforeAction($event) {

        $auth   = Yii::$app->authManager;
        $isAjax = Yii::$app->request->getIsAjax();
        $session = Yii::$app->session;
        $worker = $session->get('worker');

        //已登陆
        if ($worker && $worker->role_id && $worker->id) {
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
