<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "worker".
 *
 * @property integer $id
 * @property string $account_name
 * @property string $account_password
 * @property string $phone
 * @property integer $sex
 * @property integer $role_id
 * @property string $wchat
 * @property integer $brand_id
 * @property integer $area_id
 * @property integer $create_time
 */
class Worker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'worker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'role_id', 'brand_id', 'area_id', 'create_time'], 'integer'],
            [['role_id'], 'required'],
            [['account_name', 'account_password', 'phone', 'wchat'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_name' => 'Account Name',
            'account_password' => 'Account Password',
            'phone' => 'Phone',
            'sex' => 'Sex',
            'role_id' => 'Role ID',
            'wchat' => 'Wchat',
            'brand_id' => 'Brand ID',
            'area_id' => 'Area ID',
            'create_time' => 'Create Time',
        ];
    }

    /**
     *
     *
     *
     * 筛选（区域，省份，品牌，角色）
     * 搜索（手机号，名字）
     * @param null $option
     */
    public function search($option = null){
        $query = $this->find();

        $select = [
            'worker.*',
            'b.name'=>'brand_name',
            'c.name'=>'city_name'
        ];
        $query->select($select);


        if($option){

            //筛选品牌
            if(isset($option['brand_id']) && $option['brand_id']){
                $query->andWhere(['worker.id'=>(int)$option['brand_id']]);
            }
            //筛选区域
            if(isset($option['area_id']) && $option['area_id']){
                $query->andWhere(['worker.area_id'=>(int)$option['area_id']]);
            }
            //筛选省份
            if(isset($option['city_id']) && $option['city_id']){
                $query->andWhere(['worker.city_id'=>(int)$option['city_id']]);
            }
            //筛选角色
            if(isset($option['role_id']) && $option['role_id']){
                $query->andWhere(['worker.role_id'=>(int)$option['role_id']]);
            }



            // 搜索（手机号，名字）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("worker.phone  LIKE '%$search%' OR users.account_name LIKE '%$search%'");
            }
        }


        $query->leftJoin(['c'=>'city'],'worker.city_id=c.id')
            ->leftJoin(['b'=>'brand'],'worker.brand_id=b.id');

        $res = $query->asArray()->all();

        return $res;
    }
}
