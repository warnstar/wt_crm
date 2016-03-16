<?php
namespace backend\controllers;

use app\models\Area;
use app\models\Brand;
use app\models\Medical_group;
use app\models\Medical_group_user;
use app\models\Users;
use yii\base\ErrorException;
use Yii;
use app\controllers\CommonController;

/**
 * Site controller
 */
class VisitController extends CommonController
{


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

    //回访列表
    public function  actionVisit_list(){
        $data = [];
        return $this->render("visit_list",$data);
    }


    //待回访列表
    public function actionUn_visit_list(){
        return $this->render("un_visit_list");
    }

    //回访
    public function actionVisit_do(){
        return $this->render("visit_do");
    }

    //回访完成
    public function actionVisit_do_save(){

    }
    //==>回访异常
    public function actionVisit_error(){
        return $this->render("visit_error");
    }
    //==>回访异常
    public function actionVisit_error_save(){

    }


    //添加备注
    public function actionVisit_note_add(){
        return $this->render("visit_note_add");
    }
    public function actionVisit_note_add_save(){

    }
}
