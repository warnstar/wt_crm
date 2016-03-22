<?php
namespace backend\controllers;


use common\models\Brand;
use common\models\Festival;
use Yii;

/**
 * Site controller
 */
class FestivalController extends CommonController
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
        $data['festivals'] = (new \common\models\Festival())->search();

        return $this->render('festival_list',$data);
    }

    public function actionDetail(){
        $id = Yii::$app->request->get('id');

        $brand = (new Brand())->detail($id);

        if($brand){
            $data['brand'] = $brand;
            return $this->render('brand_detail',$data);
        }else{
            exit("无详情！");
        }

    }

    public function actionAdd(){
        return $this->render('festival_add');
    }

    public function actionSave(){
        $post = Yii::$app->request->post();
        $festival = new Festival();

        if(isset($post['id']) && $post['id']){
            $festival = (new Festival())->findOne($post['id']);
        }

        $festival->name = isset($post['name']) ? $post['name'] : null;

        $festival->start_time = isset($post['start_time']) ? strtotime(date("2016-m-d",strtotime($post['start_time']))) : null;
        $festival->greeting = isset($post['greeting']) ? $post['greeting'] : null;
        if(!$festival->id){
            $festival->create_time = time();
        }
        $msg['status'] = 0;


        if($festival->save()){
            $msg['status'] = 1;
        }else{
            $msg['error'] = "操作失败！";
        }


        return json_encode($msg);
    }
    public function actionDelete(){
        $id = Yii::$app->request->post('id');

        $festival = (new Festival())->find()->where(['id'=>$id])->one();
        $msg['status'] = 0;
        if($festival->delete()){
            $msg['status'] = 1;
        }else{
            $msg['error' ]= "删除失败！";
        }
        return json_encode($msg);
    }
}
