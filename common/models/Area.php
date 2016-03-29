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

    public function delete_this($id = 0){
        if($id == 0){
            $msg['code'] = 10;
            $msg['error'] = "根区域不允许删除";
            return $msg;
        }

        $area = (new Area())->find()->where(['id'=>$id])->one();
        if(!$area){
            $msg['code'] = 3;
            $msg['error'] = "要删除用户对象不存在!";
            return $msg;
        }
        $area_lower = $this->find()->where(['parent_id'=>$id])->one();
        $users = (new Users())->find()->where(['area_id'=>$id])->one();
        $workers = (new Worker())->find()->where(['area_id'=>$id])->one();

        if($area_lower){
            $msg['code'] = 10;
            $msg['error'] = "有子区域的区域不允许删除";
        }
        if($users){
            $msg['code'] = 10;
            $msg['error'] = "有用户的区域不允许删除";
        }
        if($workers){
            $msg['code'] = 10;
            $msg['error'] = "有职员的区域不允许删除";
        }

        if(!isset($msg)){
            if($area->delete()){
                $msg['code'] = 0;
            }else{
                $msg['code'] = 6;
                $msg['error'] = "数据库操作失败！";
            }
        }

        return $msg;
    }

    public function getAreaMui(){
        $area_mui = [];
        $area_higher = $this->find()->where(['parent_id'=>0])->asArray()->all();
        if($area_higher){
            foreach ($area_higher as $k=>$v){
                $area_mui[$k]['text'] = $v['name'];
                $area_mui[$k]['value'] = $v['id'];

                $childrens = $this->find()->where(['parent_id'=>$v['id']])->asArray()->all();
                if($childrens){
                    $child = [];
                    foreach ($childrens as $kk=>$vv){
                        $child[$kk]['text'] = $vv['name'];
                        $child[$kk]['value'] = $vv['id'];
                    }
                    $area_mui[$k]['children'] = $child;
                }
            }
        }
        return $area_mui;
    }
}
