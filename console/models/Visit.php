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
            [['mgu_id', 'worker_id','type', 'create_time','error_end_time'], 'integer'],
            [['notify_user','error_content'], 'string'],
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
            'error_end_time'=>'Error_end_time',
            'notify_user'=>'Notify_user',
            'error_content'=>'Error_content'
        ];
    }
    public function search($option = null){
        $query = $this->find();

        $select = [
            'visit.*',
            'brand_id'  =>'b.id',
            'brand_name'=>'b.name',
            'user_name'=>'users.name',
            'user_passport'=>'users.passport',
            'worker_name'=>'w.name'
        ];
        $query->select($select);



        if($option){

            //待处理用户筛选
            if(isset($option['undo_error']) && $option['undo_error']){
                $query->andWhere(['visit.type'=>2]);//异常记录
                $query->andWhere(['visit.type_status'=>0]);//未处理
            }
            //获取有待处理客服问题的品牌。
            if(isset($option['un_deal_brand']) && $option['un_deal_brand']){
                $query->groupBy('brand_id');
            }

            //已处理用户筛选
            if(isset($option['had_do_error']) && $option['had_do_error']){
                $query->andWhere(['visit.type'=>2]);//异常记录
                $query->andWhere(['visit.type_status'=>1]);//已处理
            }

            //筛选职员（创建者）
            if(isset($option['worker_id']) && $option['worker_id']){
                $query->andWhere(['visit.worker_id'=>(int)$option['worker_id']]);
            }

            //筛选疗程
            if(isset($option['mgu_id']) && $option['mgu_id']){
                $query->andWhere(['visit.mgu_id'=>(int)$option['mgu_id']]);
            }

            //筛选品牌
            if(isset($option['brand_id']) && $option['brand_id']){
                $query->andWhere(['b.id'=>(int)$option['brand_id']]);
            }

            //筛选区域
            if(isset($option['area_id']) && $option['area_id']){
                $query->andWhere(['users.area_id'=>(int)$option['area_id']]);
            }
            //筛选上级区域
            if(isset($option['area_higher_id']) && $option['area_higher_id']){
                $area_higher_id = $option['area_higher_id'];
                $query->andWhere("users.area_id in (select id FROM area WHERE parent_id = $area_higher_id)");
            }

            //筛选医疗团
            if(isset($option['medical_group_id']) && $option['medical_group_id']){
                $query->andWhere(['mgu.medical_group_id'=>(int)$option['medical_group_id']]);
            }

            //搜索(护照号，姓名，手机号，病历号）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("users.passport  LIKE '%$search%' OR users.name LIKE '%$search%' OR users.phone LIKE '%$search%' OR users.cases_code LIKE '%$search%'");
            }
        }


        $query->leftJoin(['mgu'=>'medical_group_user'],'visit.mgu_id=mgu.id')
            ->leftJoin(['users'],'mgu.user_id=users.id')
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

    //已处理客户
    public function had_do_error_users($option = null){

        $option['had_do_error'] = true;


        $data = $this->search($option);

        return $data;
    }

    //待处理客户
    public function undo_error_users($option = null){

        $option['undo_error'] = true;


        $data = $this->search($option);

        return $data;
    }

    public function un_deal_brand($option = null){
        $option['undo_error'] = true;
        $option['un_deal_brand'] = true;

        $res = $this->search($option);
        $workers = [];
        if(isset($res['list']) && $res['list']){
            foreach($res['list'] as $v){
                $workers[]  = (new Worker())->find()->where(['brand_id'=>$v['brand_id'],'role_id'=>3])->asArray()->one();
            }
        }

        //处理，除去null的
        $data = [];
        if($workers) foreach($workers as $v){
            if($v){
                $data[] = $v;
            }
        }
        return $data;
    }
    public function detail($id){
        $query = $this->find();

        $select = [
            'visit.*',

            'brand_id'  =>'b.id',
            'brand_name'=>'b.name',

            'user_id'       =>'u.id',
            'user_name'     =>'u.name',
            'user_sex'      =>'u.sex',
            'user_birth'    =>'u.birth',
            'user_phone'    =>'u.phone',
            'user_passport' =>'u.passport',
            'user_cases_code'=>'u.cases_code',
            'user_area'     =>'a.name',

            'start_time_mgu'    =>  'mgu.start_time',
            'end_time_mgu'      =>  'mgu.end_time',

            'worker_name'=>'w.name'
        ];
        $query->select($select);

        $query->where(['visit.id'=>$id]);


        $query->leftJoin(['mgu'=>'medical_group_user'],'visit.mgu_id=mgu.id')
            ->leftJoin(['u'=>'users'],'mgu.user_id=u.id')
            ->leftJoin(['a'=>'area'],'u.area_id=a.id')
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
