<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $attention
 * @property integer $manager_id
 * @property integer $create_time
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['manager_id', 'create_time'], 'integer'],
            [['name', 'desc', 'attention'], 'string', 'max' => 255]
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
            'desc' => 'Desc',
            'attention' => 'Attention',
            'manager_id' => 'Manager ID',
            'create_time' => 'Create Time',
        ];
    }

     public function detail($id){
         if($id){
             $query = $this->find();

             $select = [
                 'brand.*',
                 'worker_name'=>'worker.name'
             ];
             $query->select($select);

             $query->where(['brand.id'=>$id]);

             $query->leftJoin(['worker'],'brand.manager_id=worker.id');
             $res = $query->asArray()->one();

             return $res;
         }else{
             return null;
         }
     }

     public function exist(){
         $brand = $this->findOne(['name'=>$this->name]);

         if($brand){

             if($this->id){
                 if($brand->id == $this->id){
                     return false;
                 }
             }
             return true;
         }else{
             return false;
         }
     }
     public function search($option = null){
        $query = $this->find();

        $select = [
            'brand.*',
            'worker_name'=>'worker.name'
        ];
        $query->select($select);

         if($option){
             if(isset($option['unset_manager']) && $option['unset_manager']){
                 $query->andWhere(['brand.manager_id'=>0]);
             }
         }

        $query->leftJoin(['worker'],'brand.manager_id=worker.id');
        $res = $query->asArray()->all();

        return $res;
    }

    public function delete_this($id = 0){

        $area = (new Brand())->find()->where(['id'=>$id])->one();
        if(!$area){
            $msg['code'] = 3;
            $msg['error'] = "要删除用户对象不存在!";
            return $msg;
        }

        $users = (new Users())->find()->where(['brand_id'=>$id])->one();
        $workers = (new Worker())->find()->where(['brand_id'=>$id])->one();
        $groups = (new Medical_group())->find()->where(['brand_id'=>$id])->one();

        if($groups){
            $msg['code'] = 10;
            $msg['error'] = "有出团的品牌不允许删除";
        }
        if($users){
            $msg['code'] = 10;
            $msg['error'] = "有用户的品牌不允许删除";
        }
        if($workers){
            $msg['code'] = 10;
            $msg['error'] = "有职员的品牌不允许删除";
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

}
