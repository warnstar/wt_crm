<?php
namespace backend\controllers;


use common\models\Note_type;
use Yii;

/**
 * Site controller
 */
class NoteController extends CommonController
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

    }

    public function actionDetail(){

    }

    public function actionAdd(){
        return $this->render('festival_add');
    }

    public function actionNote_type_list(){
        $data['note_types'] = (new Note_type())->find()->asArray()->all();


        return $this->render('note_type_list',$data);
    }
    public function actionNote_type_detail(){
        $id = Yii::$app->request->get('id');
        $data['note_type'] = (new Note_type())->findOne($id);
        return $this->render("note_type_detail",$data);
    }
    public function actionNote_type_add(){
        return $this->render('note_type_add');
    }
    public function  actionNote_type_save(){
        $post = Yii::$app->request->post();
        $note_type = new Note_type();

        if(isset($post['id']) && $post['id']){
            $note_type = (new Note_type())->findOne($post['id']);
        }

        $note_type->name = isset($post['name']) ? $post['name'] : null;

        if(!$note_type->id){
            $note_type->create_time = time();
        }
        $msg['status'] = 0;


        if($note_type->save()){
            $msg['status'] = 1;
        }else{
            $msg['error'] = "操作失败！";
        }


        return json_encode($msg);
    }

    public function actionNote_type_delete(){
        $id = Yii::$app->request->post("id");

        $msg['status'] = 0;

        $res = (new Note_type())->delete_this($id);
        if(isset($res['code']) && $res['code'] == 0){
            $msg['status'] = 1;
        }else{
            $msg['error'] = $res['error'];
        }

        return json_encode($msg);
    }
}
