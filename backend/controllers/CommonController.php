<?php
namespace backend\controllers;


use common\Excel;
use common\models\Medical_group_user;
use common\models\SysSms;
use common\models\Visit;
use common\models\Worker;
use Yii;
use yii\web\Controller;
use yii\web\Response;
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
    public $worker_id   = -1;

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
            $this->worker_id    = $worker['id'];

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

    //主页
    public function actionHome(){

        return $this->render("home");
    }


    /**
     * ==============================测试=====================================
     */



    /**
     * 短信测试
     */
    public function actionSms_test(){
        $phone = "15918604869";
        //$res = (new SysSms())->undo_notice($phone);
        $res = (new SysSms())->error_notice($phone,4);

        dump($res);

    }

    public function actionExcel_import(){


        return $this->render("excel");
    }

    public function actionExcel_save(){
        if(isset($_FILES['excel_data'])){
            $objPHPExcel = \PHPExcel_IOFactory::load($_FILES['excel_data']['tmp_name']);

            $sheet = $objPHPExcel->getSheet(0); // 读取第一個工作表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数


            /** 循环读取每个单元格的数据 */
            $dataset = [];
            for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始

                for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                    $dataset[$row][$column] = $sheet->getCell($column.$row)->getValue();

                }
            }

        }else{
            echo "文件不对！";
        }

    }


    public function actionEnglish(){
        $row_flag = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
        $row_flag =  explode(',',$row_flag);
        dump($row_flag);
    }

    public function actionNotice(){
        $notify_user = "3,5,6,4";
        $workers  = (new Worker())->getRoleWorker($notify_user,20);
        dump($workers);
    }

    public function actionGroup_user_export_test(){
        $res = (new Medical_group_user())->excel_data(9);

        if($res){
            if(isset($res['excel_title']) && isset($res['excel_data']) && isset($res['excel_name'])){
                (new Excel())->export_data($res['excel_data'],$res['excel_title'],$res['excel_name']);
            }

        }

    }
    public function actionUn_deal(){
        $res = (new Visit())->un_deal_brand();

        dump($res);
    }
}
