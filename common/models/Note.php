<?php

namespace common\models;

use common\lib\oss\Oss;
use Yii;

/**
 * This is the model class for table "note".
 *
 * @property integer $id
 * @property integer $visit_id
 * @property integer $mgu_id
 * @property integer $type
 * @property string $content
 * @property integer $content_type
 * @property string $notify_user
 * @property integer $general_note_type
 * @property integer $worker_id
 * @property integer $create_time
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visit_id', 'mgu_id', 'type', 'content_type', 'general_note_type', 'worker_id', 'create_time','user_view'], 'integer'],
            [['mgu_id', 'type', 'content_type'], 'required'],
            [['content'], 'string'],
            [['notify_user'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visit_id' => 'Visit ID',
            'mgu_id' => 'Mgu ID',
            'type' => 'Type',
            'content' => 'Content',
            'content_type' => 'Content Type',
            'notify_user' => 'Notify User',
            'general_note_type' => 'General Note Type',
            'worker_id' => 'Worker ID',
            'user_view'=>'User_view',
            'create_time' => 'Create Time',
        ];
    }
    public function search($option = null){
        $query = $this->find();

        $select = [
            'note.*',
            'worker_name'=>'w.name',
            'worker_role'=>'r.name',

            'type_name'=>'gt.name'
        ];
        $query->select($select);

        $query->orderBy("note.create_time asc");
        if($option){
            //筛选创建者
            if(isset($option['worker_id']) && $option['worker_id']){
                $query->andWhere(['note.worker_id'=>(int)$option['worker_id']]);
            }

            //筛选回访记录
            if(isset($option['visit_id']) && $option['visit_id']){
                $query->andWhere(['note.visit_id'=>(int)$option['visit_id']]);
            }

            //筛选疗程
            if(isset($option['mgu_id']) && $option['mgu_id']){
                $query->andWhere(['note.mgu_id'=>(int)$option['mgu_id']]);
            }

            //筛选用户可见
            if(isset($option['user_view'])){
                $condition = [
                    "note.user_view"    =>  (int)$option['user_view'],
                    'type'              =>  1
                ];
                $query->andWhere($condition);
            }
        }

        $query->leftJoin(['w'=>'worker'],'note.worker_id=w.id')
            ->leftJoin(['gt'=>'note_type'],'note.general_note_type=gt.id')
            ->leftJoin(['r'=>'worker_role'],'w.role_id=r.id');


        $data = $query->asArray()->all();

        return $data;
    }

    public function delete_this($id = 0){

        $data = (new Note())->find()->where(['id'=>$id])->one();
        if(!$data){
            $msg['code'] = 3;
            $msg['error'] = "要删除用户对象不存在!";
            return $msg;
        }

        if(!isset($msg)){
            //删除资源
            if($data->content_type == 2 || $data->content_type ==3){
                $content = json_decode($data->content);

                if($content){
                    foreach($content as $v){

                        $flag['content_res'][] = (new Oss())->file_del($v->url_object);
                    }
                }
            }
            if($data->delete()){
                $msg['code'] = 0;
            }else{
                $msg['code'] = 6;
                $msg['error'] = "数据库操作失败！";
            }
        }

        return $msg;
    }
}
