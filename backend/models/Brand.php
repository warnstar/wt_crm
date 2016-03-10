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


    public function search(){
        $query = $this->find();

        $select = [
            'brand.*',
            'worker.name'=>'worker_name',
        ];
        $query->select($select);

        $query->leftJoin(['worker'],'brand.manager_id=worker_id');

        $res = $query->asArray()->all();

        return $res;
    }

}
