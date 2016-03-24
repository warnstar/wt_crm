<?php
namespace backend\controllers;


use common\models\Area;
use Yii;

/**
 * Site controller
 */
class AreaController extends CommonController
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

    public function  actionList(){

        $data['areas'] = (new Area())->get_lower(null);

        return $this->render('area_list',$data);
    }

    public function actionList_ajax(){
        $id = Yii::$app->request->get('id');
        $search = Yii::$app->request->get('search');

        $option['parent_id'] = $id;
        $option['search'] = $search;
        $data['areas'] = (new Area())->search($option);

        return $this->renderPartial("area_list_ajax",$data);
    }
    public function actionDetail(){
        return $this->render('area_detail');
    }

    public function actionAdd(){
        $data['area_higher'] = (new Area())->get_lower(0);
        return $this->render('area_add',$data);
    }

    /**
     * 区域下拉菜单（无条件）
     * @return string
     */
    public function actionArea_select(){
        $get = Yii::$app->request->get();

        $option = [];
        if(isset($get['id']) && $get['id'] >= 0){
            $option['parent_id'] = (int)$get['id'];
        }

        $data['areas'] = (new Area())->search($option);

        return $this->renderPartial("area_select",$data);
    }
    public function actionArea_select_role_brand(){
        $get = Yii::$app->request->get();
        //角色id和品牌id
        $data = [];
        if(isset($get['id']) && $get['id'] >= 0){
            $option['parent_id'] = (int)$get['id'];
        }
        if(isset($get['role_id']) && $get['role_id'] && isset($get['brand_id']) && $get['brand_id']){
            $option['role_id'] = $get['role_id'];
            $option['brand_id'] = $get['brand_id'];
            $data['areas'] = (new Area())->unset_area_manager($option);
        }
        return $this->renderPartial("area_select",$data);
    }
    public function actionSave(){
        $post = Yii::$app->request->post();
        $area = new Area();

        if(isset($post['id']) && $post['id']){
            $area = (new Area())->findOne($post['id']);
        }

        $area->name = isset($post['name']) ? $post['name'] : null;
        $area->parent_id = isset($post['parent_id']) ? $post['parent_id'] : null;
        if(!$area->id){
            $area->create_time = time();
        }
        $msg['status'] = 0;
        $msg['error'] = "操作失败！";

        if($area->exist()){
            $msg['error'] = "区域名称不能重复！";
        }else{
            if($area->save()){
                $msg['status'] = 1;
                unset($msg['error']);
            }
        }

        return json_encode($msg);
    }

    public function actionDelete(){
        $id = Yii::$app->request->post("id");

        $msg['status'] = 0;

        $res = (new Area())->delete_this($id);
        if(isset($res['code']) && $res['code'] == 0){
            $msg['status'] = 1;
        }else{
            $msg['error'] = $res['error'];
        }

        return json_encode($msg);
    }
}
