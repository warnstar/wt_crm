<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "medical_group_user".
 *
 * @property integer $id
 * @property integer $medical_group_id
 * @property integer $user_id
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $create_time
 */
class Medical_group_user extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medical_group_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medical_group_id', 'user_id'], 'required'],
            [['medical_group_id', 'user_id', 'start_time', 'end_time', 'create_time','next_visit','last_visit'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medical_group_id' => 'Medical Group ID',
            'user_id' => 'User ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'next_visit'=>"Next_visit",
            'last_visit'=>'Last_visit',
            'create_time' => 'Create Time',
        ];
    }
    public function search($option = null){
        $query = $this->find();

        $select = [
            'medical_group_user.*',
            'user_name'=>'users.name',
            'user_passport'=>'users.passport',
            'brand_name'            =>  'b.name'
        ];
        $query->select($select);


        if($option){
            //待访问客户
            if(isset($option['un_visit']) && $option['un_visit']){
                //当前处于疗程
                //当前时间（算今天结束后的时间）
                $this_time = time();
                $query->andWhere("medical_group_user.start_time <= $this_time && medical_group_user.end_time > $this_time");

                //获取待访问的（当前时间小于要访问的时间）
                $query->andWhere("medical_group_user.next_visit <= $this_time");

                //未访问过，
                $query->orWhere("medical_group_user.last_visit = 0");

            }

            //筛选用户参加的
            if(isset($option['user_id']) && $option['user_id']){
                $query->andWhere(['medical_group_user.user_id'=>(int)$option['user_id']]);
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

            //筛选某医疗团下所有的成员
            if(isset($option['medical_group_id']) && $option['medical_group_id']){
                $query->andWhere(['medical_group_user.medical_group_id'=>(int)$option['medical_group_id']]);
            }

            //搜索(护照号，姓名，手机号，病历号）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("users.passport  LIKE '%$search%' OR users.name LIKE '%$search%' OR users.phone LIKE '%$search%' OR users.cases_code LIKE '%$search%'");
            }

        }


        $query->leftJoin(['users'],'medical_group_user.user_id=users.id')
            ->leftJoin(['mg'=>'medical_group'],'medical_group_user.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id');

        $data = $query->asArray()->all();
        $pages = new Pagination([
            'totalCount'    => $query->count(),
            'pageSize'      => 9,
        ]);
        $query->offset($pages->offset)
            ->limit($pages->limit);


        $list = $query->asArray()->all();

        $data['list'] = $list;
        $data['pages'] = $pages;

        return $data;
    }

    //待访客户
    public function un_visit_users($option = null){
        //brand_id,
        $option['un_visit'] = true;


        $data = $this->search($option);

        return $data;
    }

    //疗程详情
    public function detail($id){
        $query = $this->find();

        $select = [
            'users.*',
            'medical_group_user.*',
            'brand_id'              =>  'b.id',
            'brand_name'            =>  'b.name',
            'group_name'            =>  'mg.name'
        ];
        $query->select($select);

        $query->andWhere(['medical_group_user.id'=>$id]);

        $query->leftJoin(['users'],'medical_group_user.user_id=users.id')
            ->leftJoin(['mg'=>'medical_group'],'medical_group_user.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id');

        $data = $query->asArray()->one();

        return $data;
    }

    public function exist(){
        $data = $this->find()->where(['medical_group_id'=>$this->medical_group_id,'user_id'=>$this->user_id])->one();

        if($data){
            if($this->id){
                if($data->id == $this->id){
                    return false;
                }
            }
            return true;
        }else{
            return false;
        }
    }

}
