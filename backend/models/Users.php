<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $passport
 * @property integer $birth
 * @property string $phone
 * @property integer $sex
 * @property integer $status
 * @property integer $city_id
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
            [['nickname', 'passport'], 'required'],
            [['birth', 'sex', 'status', 'city_id', 'area_id', 'create_time'], 'integer'],
            [['nickname', 'passport', 'phone', 'wchat'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'passport' => 'Passport',
            'birth' => 'Birth',
            'phone' => 'Phone',
            'sex' => 'Sex',
            'status' => 'Status',
            'city_id' => 'City ID',
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
            'user.*',
            'mgu.end_time'      =>  'end_time_mgu',
            'mgu.start_time'    =>  'start_time_mgu',
            'mg.name'           =>  'group_name',
            'b.id'              =>  'brand_id',
            'b.name'            =>  'brand_name',
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
            //筛选省份
            if(isset($option['city_id']) && $option['city_id']){
                $query->andWhere(['users.city_id'=>(int)$option['city_id']]);
            }
            //筛选医疗团
            if(isset($option['medical_group_id']) && $option['medical_group_id']){
                $query->andWhere(['mg.id'=>(int)$option['medical_group_id']]);
            }



            //搜索(护照号，手机号，病历号）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("users.passport  LIKE '%$search%' OR users.phone LIKE '%$search%' OR users.cases_code LIKE '%$search%'");
            }
        }


        $query->leftJoin(['mgu'=>'medical_group_user'],'user.last_mgu=mgu.id')
            ->leftJoin(['mg'=>'medical_group'],'mgu.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id');

        $res = $query->asArray()->all();

        return $res;
    }
}
