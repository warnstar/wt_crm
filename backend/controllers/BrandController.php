<?php
namespace backend\controllers;

use app\models\Brand;
use app\models\Worker;
use Yii;

/**
 * Site controller
 */
class BrandController extends CommonController
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
        $data['brand_list'] = (new Brand())->search();

        return $this->render('brand_list',$data);
    }

    public function actionDetail(){
        $id = Yii::$app->request->get('id');

        $data['workers'] = (new Worker())->find()->where(['role_id'=>7])->asArray()->all();
        $brand = (new Brand())->detail($id);
        $data['brand'] = $brand;
        if($brand){

            return $this->render('brand_detail',$data);
        }else{
            exit("无详情！");
        }

    }

    public function actionAdd(){
        $data['workers'] = (new Worker())->find()->where(['role_id'=>7])->asArray()->all();
        return $this->render('brand_add',$data);
    }

    public function actionSave(){
        $post = Yii::$app->request->post();
        $brand = new Brand();

        if(isset($post['id']) && $post['id']){
            $brand = (new Brand())->findOne($post['id']);
        }

        $brand->name = isset($post['name']) ? $post['name'] : null;
        $brand->desc = isset($post['desc']) ? $post['desc'] : null;
        $brand->attention = isset($post['attention']) ? $post['attention'] : null;
        $brand->manager_id = isset($post['manager_id']) ? $post['manager_id'] : null;
        if(!$brand->id){
            $brand->create_time = time();
        }
        $msg['status'] = 0;
        $msg['error'] = "操作失败！";
        if($brand->exist()){
           $msg['error'] = "品牌名称不能重复！";
        }else{
            if($brand->save()){
                $worker = (new Worker())->find()->where(['id'=>$brand->manager_id])->one();
                if($worker){
                    $worker->role_id = 4;
                    $worker->save();
                }
                $msg['status'] = 1;
            }
        }

        return json_encode($msg);
    }
    public function actionBrand_select(){
        $get = Yii::$app->request->get();

        $option = [];
        if(isset($get['role_id']) && $get['role_id']){
            //品牌经理
            if($get['role_id'] == 4){
                $option['unset_manager'] = true;
            }
        }

        $data['brands'] = (new Brand())->search($option);

        return $this->renderPartial('brand_select',$data);
    }
}
