<?php

namespace app\models;

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

    public function delete_this($id = null)
    {
        if(!$id){
            $id = $this->id;
        }

    }

}
