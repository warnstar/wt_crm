<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property string $area_name
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
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
        ];
    }


    public function search($option = null){
        $query = $this->find();

        $select = [
            'area.*',
            'parent_name'=>'parent.name'

        ];
        $query->select($select);

        $query->where("area.id > :id",[':id'=>0]);

        if($option){
            if(isset($option['parent_id']) && ($option['parent_id'] >= 0)){
                $query->andWhere(['area.parent_id'=>$option['parent_id']]);
            }

            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                $query->andWhere("area.name  LIKE '%$search%'");
            }
        }

        $query->leftJoin(['parent'=>'area'],'area.parent_id=parent.id');



        $data = $query->asArray()->all();

        return $data;
    }

    public function get_lower($id = 0){
        $option['parent_id'] = $id;

        return $this->search($option);
    }

    public function unset_area_manager($option = []){
        $role_id = 0;
        $brand_id = 0;
        $parent_id = 0;

        if(isset($option['parent_id']) && $option['parent_id']){
            $parent_id = $option['parent_id'];
        }
        if(isset($option['brand_id']) && isset($option['brand_id'])){
            $brand_id = $option['brand_id'];
            $role_id = $option['role_id'];
        }
        if($role_id && $brand_id){
            $query = $this->find();

            $select = [
                'area.*',
                'parent_name'=>'parent.name'

            ];
            $query->select($select);

            $query->where(['area.parent_id'=>$parent_id]);
            if($role_id == 6){
                $query->andWhere("area.id not in (select area_id FROM worker WHERE brand_id = $brand_id AND role_id = $role_id)");
            }else if($role_id == 5){
                $query->andWhere("area.id not in (select area.parent_id FROM worker LEFT JOIN `area` ON area.id = worker.area_id WHERE brand_id = $brand_id AND role_id = $role_id )");
            }

            $query->leftJoin(['parent'=>'area'],'area.parent_id=parent.id');


            $data = $query->asArray()->all();
        }else{
            $data = [];
        }

        return $data;
    }

    //获取完全区域名
    public function complete_area_name($id){
        $query = $this->find();

        $select = [
            'area.id',
            'area.name',
            'higher_id'=> 'higher_area.id',
            'higher_name'=> 'higher_area.name'
        ];
        $query->select($select);

        $query->andWhere(['area.id'=>$id]);

        $query->leftJoin(['higher_area'=>'area'],'area.parent_id=higher_area.id');

        $data = $query->asArray()->one();

        return $data;
    }

    public function exist(){
        $data = $this->findOne(['name'=>$this->name]);

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
