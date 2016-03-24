<?php

namespace common\models;

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
            [['visit_id', 'mgu_id', 'type', 'content_type', 'general_note_type', 'worker_id', 'create_time'], 'integer'],
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
        }

        $query->leftJoin(['w'=>'worker'],'note.worker_id=w.id')
            ->leftJoin(['gt'=>'note_type'],'note.general_note_type=gt.id')
            ->leftJoin(['r'=>'worker_role'],'w.role_id=r.id');


        $data = $query->asArray()->all();

        return $data;
    }
}
