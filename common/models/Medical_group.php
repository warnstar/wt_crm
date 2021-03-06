<?php

namespace common\models;

use Yii;
use yii\data\Pagination;
/**
 * This is the model class for table "medical_group".
 *
 * @property string $id
 * @property string $group_code
 * @property integer $brand_id
 * @property string $name
 * @property integer $user_count
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $create_time
 */
class Medical_group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medical_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_code', 'brand_id', 'name'], 'required'],
            [['brand_id', 'user_count', 'start_time', 'end_time', 'create_time'], 'integer'],
            [['group_code', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_code' => 'Group Code',
            'brand_id' => 'Brand ID',
            'name' => 'Name',
            'user_count' => 'User Count',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'create_time' => 'Create Time',
        ];
    }
    public function exist(){
        $data = $this->findOne(['group_code'=>$this->group_code]);

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
    public function check(){
        $msg['code'] = 0;

        if($this->start_time >= $this->end_time){
            $msg['code'] = 8;
            $msg['error'] = "出发时间不能小于回国时间！";
            return $msg;
        }


        return $msg;
    }
    public function search($option = null){
        $query = $this->find();

        $select = [
            'medical_group.*',
            'brand_name'=>'brand.name'
        ];
        $query->select($select);

        if($option){
            //筛选品牌
            if(isset($option['brand_id']) && $option['brand_id']){
                $query->andWhere(['brand.id'=>(int)$option['brand_id']]);
            }

            //搜索(护照号，手机号，病历号）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("medical_group.name  LIKE '%$search%'");
            }
        }

        $query->leftJoin(['brand'],'medical_group.brand_id=brand.id');


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
            'medical_group.*',
            'brand_name'=>'brand.name'
        ];
        $query->select($select);

        $query->where(['medical_group.id'=>$id]);
        $query->leftJoin(['brand'],'medical_group.brand_id=brand.id');

        $data = $query->asArray()->one();

        return $data;
    }

    public function delete_this($id = 0){

        $data = (new Medical_group())->find()->where(['id'=>$id])->one();
        if(!$data){
            $msg['code'] = 3;
            $msg['error'] = "要删除用户对象不存在!";
            return $msg;
        }

        $mgu = (new Medical_group_user())->find()->where(['medical_group_id'=>$id])->one();

        if($mgu){
            $msg['code'] = 10;
            $msg['error'] = "有团员的出团不允许删除";
        }

        if(!isset($msg)){
            if($data->delete()){
                $msg['code'] = 0;
            }else{
                $msg['code'] = 6;
                $msg['error'] = "数据库操作失败！";
            }
        }

        return $msg;
    }

    public function getGroupsMui($brand_id = 0){
        $group_mui = [];
        $groups = (new Medical_group())->find()->where(['brand_id'=>$brand_id])->all();
        if($groups){
            foreach ($groups as $k=>$v){
                $group_mui[$k]['text'] = $v->name;
                $group_mui[$k]['value'] = $v->id;
            }
            $all_group = [
                "text"  =>   "所有出团",
                "value" =>   "0"
            ];
            array_unshift($group_mui,$all_group);
        }

        return $group_mui;
    }
}
