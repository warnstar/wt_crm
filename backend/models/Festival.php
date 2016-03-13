<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "festival".
 *
 * @property string $id
 * @property string $name
 * @property integer $start_time
 * @property string $greeting
 * @property integer $create_time
 */
class Festival extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'festival';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start_time', 'greeting'], 'required'],
            [['start_time', 'create_time'], 'integer'],
            [['name', 'greeting'], 'string', 'max' => 255]
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
            'start_time' => 'Start Time',
            'greeting' => 'Greeting',
            'create_time' => 'Create Time',
        ];
    }
    public function search($option = null){
        $query = $this->find();
        $select = [
            'festival.*'
        ];
        $query->select($select);

        if($option){

        }

        $order = [
            'start_time'    =>  SORT_ASC
        ];
        $query->orderBy($order);

        $data = $query->asArray()->all();

        return $data;
    }
}
