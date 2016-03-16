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
            [['medical_group_id', 'user_id', 'start_time', 'end_time', 'create_time'], 'integer']
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
            'create_time' => 'Create Time',
        ];
    }
    public function search($option = null){
        $query = $this->find();

        $select = [
            'medical_group_user.*',
            'users.*',
            'brand_name'            =>  'b.name'
        ];
        $query->select($select);


        if($option){

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

            //搜索(护照号，手机号，病历号）
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
            'route'         => "users/list"
        ]);
        $query->offset($pages->offset)
            ->limit($pages->limit);


        $list = $query->asArray()->all();

        $data['list'] = $list;
        $data['pages'] = $pages;

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
