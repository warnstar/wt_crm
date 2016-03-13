<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * This is the model class for table "worker".
 *
 * @property integer $id
 * @property string $name
 * @property string $password
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
            [['name', 'password', 'phone', 'wchat'], 'string', 'max' => 255]
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
            'password' => 'Password',
            'phone' => 'Phone',
            'sex' => 'Sex',
            'role_id' => 'Role ID',
            'wchat' => 'Wchat',
            'brand_id' => 'Brand ID',
            'area_id' => 'Area ID',
            'create_time' => 'Create Time',
        ];
    }


    public function login(){
        $worker = (new Worker())->findOne(['phone'=>$this->phone]);

        if($worker && $worker->password == $this->password){
            return $worker;
        }else{
            false;
        }
    }
    /**
     *
     *
     *
     * 筛选（区域，省份，品牌，角色）
     * 搜索（手机号，名字）
     * @param null $option
     * @param false  (默认返回数据数组，可选返回provider)
     */
    public function search($option = null,$is_provider = false){
        $query = $this->find();

        $select = [
            'worker.*',
            'brand_name'=>'b.name',
            'area_name'=>'a.name',
            'role_name'=>'r.name'
        ];
        $query->select($select);

        $query->andWhere("worker.role_id > :role_id",[':role_id'=>1]);

        if($option){

            //筛选品牌
            if(isset($option['brand_id']) && $option['brand_id']){
                $query->andWhere(['worker.brand_id'=>(int)$option['brand_id']]);
            }
            //筛选区域
            if(isset($option['area_id']) && $option['area_id']){
                $query->andWhere(['worker.area_id'=>(int)$option['area_id']]);
            }
            //筛选上级区域
            if(isset($option['area_higher_id']) && $option['area_higher_id']){
                $area_higher_id = $option['area_higher_id'];
                $query->andWhere("worker.area_id in (select id FROM area WHERE parent_id = $area_higher_id)");
            }
            //筛选角色
            if(isset($option['role_id']) && $option['role_id']){
                $query->andWhere(['worker.role_id'=>(int)$option['role_id']]);
            }



            // 搜索（手机号，名字）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("worker.phone  LIKE '%$search%' OR worker.name LIKE '%$search%'");
            }
        }


        $query->leftJoin(['a'=>'area'],'worker.area_id=a.id')
            ->leftJoin(['b'=>'brand'],'worker.brand_id=b.id')
            ->leftJoin(['r'=>'worker_role'],'worker.role_id=r.id');


        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'  => 9,
            'route' => "worker/list"
        ]);
        $query->offset($pages->offset)
            ->limit($pages->limit);


        $list = $query->asArray()->all();

        $data['list'] = $list;
        $data['pages'] = $pages;
        return $data;
    }

    public function find_by_phone($phone){
        $worker = $this->find()->where(['phone'=>$phone])->asArray()->one();
        return $worker;
    }
    public function detail($id){
        $query = $this->find();
        $select = [
            'worker.*'
        ];
        $query->select($select);

        $query->where(['id'=>$id]);

        $data = $query->asArray()->one();

        return $data;
    }
    public function exist(){
        $worker = $this->findOne(['phone'=>$this->phone]);

        if($worker){
            if($this->id){
                if($worker->id == $this->id){
                    return false;
                }
            }
            return true;
        }else{
            return false;
        }
    }
}
