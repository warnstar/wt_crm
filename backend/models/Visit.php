<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property integer $id
 * @property integer $mgu_id
 * @property integer $worker_id
 * @property integer $create_time
 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mgu_id', 'worker_id', 'create_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mgu_id' => 'Mgu ID',
            'worker_id' => 'Worker ID',
            'create_time' => 'Create Time',
        ];
    }
    public function create(){
        if($this->save()){
            //汇总所有备注到此回访记录
            $notes = (new Note())->find()->andwhere(['mgu_id'=>$this->mgu_id])->andWhere("visit_id = 0")->all();

            if($notes) foreach($notes as $v){
                $v->visit_id = $this->id;
                $v->save();
            }
            return true;
        }else{
            return false;
        }
    }
}
