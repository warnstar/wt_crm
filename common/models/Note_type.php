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

        $area = (new Note_type())->find()->where(['id'=>$id])->one();
        if(!$area){
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
            if($area->delete()){
                $msg['code'] = 0;
            }else{
                $msg['code'] = 6;
                $msg['error'] = "数据库操作失败！";
            }
        }

        return $msg;
    }
}
