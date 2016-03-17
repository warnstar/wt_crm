<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

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
            [['mgu_id', 'worker_id','type', 'create_time'], 'integer'],
            [['notify_user'], 'string'],
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
            'type'      =>  'Type',
            'create_time' => 'Create Time',
            'notify_user'=>'Notify_user'
        ];
    }
    public function search($option = null){
        $query = $this->find();

        $select = [
            'visit.*',
            'brand_name'=>'b.name',
            'user_name'=>'u.name',
            'worker_name'=>'w.name'
        ];
        $query->select($select);



        if($option){
            //筛选职员（创建者）
            if(isset($option['worker_id']) && $option['worker_id']){
                $query->andWhere(['visit.worker_id'=>(int)$option['worker_id']]);
            }

            //筛选疗程
            if(isset($option['mgu_id']) && $option['mgu_id']){
                $query->andWhere(['visit.mgu_id'=>(int)$option['mgu_id']]);
            }
        }


        $query->leftJoin(['mgu'=>'medical_group_user'],'visit.mgu_id=mgu.id')
            ->leftJoin(['u'=>'users'],'mgu.user_id=u.id')
            ->leftJoin(['w'=>'worker'],'visit.worker_id=w.id')
            ->leftJoin(['mg'=>'medical_group'],'mgu.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id');


        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'  => 9,
        ]);
        $query->offset($pages->offset)
            ->limit($pages->limit);


        $list = $query->asArray()->all();

        $data['list'] = $list;
        $data['pages'] = $pages;
        return $data;
    }
    public function detail($id){
        $query = $this->find();

        $select = [
            'visit.*',
            'brand_name'=>'b.name',
            'user_name'=>'u.name',
            'user_cases_code'=>'u.cases_code',
            'worker_name'=>'w.name'
        ];
        $query->select($select);

        $query->where(['visit.id'=>$id]);


        $query->leftJoin(['mgu'=>'medical_group_user'],'visit.mgu_id=mgu.id')
            ->leftJoin(['u'=>'users'],'mgu.user_id=u.id')
            ->leftJoin(['w'=>'worker'],'visit.worker_id=w.id')
            ->leftJoin(['mg'=>'medical_group'],'mgu.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id');

        $data = $query->asArray()->one();


        return $data;
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
