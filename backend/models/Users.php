<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $passport
 * @property integer $birth
 * @property string $phone
 * @property integer $sex
 * @property integer $status
 * @property integer $cases_code
 * @property integer $area_id
 * @property string $wchat
 * @property integer $create_time
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'passport'], 'required'],
            [['birth', 'sex', 'status', 'area_id', 'create_time'], 'integer'],
            [['name', 'passport','cases_code', 'phone', 'wchat'], 'string', 'max' => 255]
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
            'passport' => 'Passport',
            'birth' => 'Birth',
            'phone' => 'Phone',
            'sex' => 'Sex',
            'cases_code'=>'Cases_code',
            'status' => 'Status',
            'area_id' => 'Area ID',
            'wchat' => 'Wchat',
            'create_time' => 'Create Time',
        ];
    }

    /**
     *
     *
     *
     * 筛选（区域，省份，医疗团）
     * 搜索（护照号，手机号，病历号）
     * @param null $option
     */
    public function search($option = null){
        $query = $this->find();

        $select = [
            'users.*',
            'end_time_mgu'          => 'mgu.end_time',
            'start_time_mgu'        =>  'mgu.start_time',
            'group_name'            =>  'mgu.start_time',
            'brand_id'              =>  'b.id',
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
            //筛选医疗团
            if(isset($option['medical_group_id']) && $option['medical_group_id']){
                $query->andWhere(['mg.id'=>(int)$option['medical_group_id']]);
            }



            //搜索(护照号，手机号，病历号）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("users.passport  LIKE '%$search%' OR users.name LIKE '%$search%' OR users.phone LIKE '%$search%' OR users.cases_code LIKE '%$search%'");
            }
        }


        $query->leftJoin(['mgu'=>'medical_group_user'],'users.last_mgu=mgu.id')
            ->leftJoin(['mg'=>'medical_group'],'mgu.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id');

        $data = $query->asArray()->all();
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'  => 9,
            'route' => "users/list"
        ]);
        $query->offset($pages->offset)
            ->limit($pages->limit);


        $list = $query->asArray()->all();

        $data['list'] = $list;
        $data['pages'] = $pages;

        return $data;
    }

    public function exist(){
        $data = $this->findOne(['passport'=>$this->passport]);

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
