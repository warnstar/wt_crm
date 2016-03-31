<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "note_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $create_time
 */
class Note_type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_time'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'create_time' => 'Create Time',
        ];
    }


    public function delete_this($id = 0){

        $data = (new Note_type())->find()->where(['id'=>$id])->one();
        if(!$data){
            $msg['code'] = 3;
            $msg['error'] = "要删除用户对象不存在!";
            return $msg;
        }

        $notes = (new Note())->find()->where(['general_note_type'=>$id])->one();

        if($notes){
            $msg['code'] = 10;
            $msg['error'] = "有备注的备注类型不允许删除";
        }


        if(!isset($msg)){
            if($data->delete()){
                $msg['code'] = 0;
            }else{
                $msg['code'] = 6;
                $msg['error'] = "数据库操作失败！";
            }
        }

        return $msg;
    }

    public function getMui(){

        $types_mui = [];
        $types = $this->find()->all();
        if($types){
            foreach ($types as $k=>$v){
                $types_mui[$k]['text'] = $v->name;
                $types_mui[$k]['value'] = $v->id;
            }
            $all_types = [
                "text"  =>   "所有类型",
                "value" =>   "0"
            ];
            array_unshift($types_mui,$all_types);
        }

        return $types_mui;
    }
}
