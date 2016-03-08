<?php

namespace app\models;

use Yii;

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
            [['id', 'group_code', 'brand_id', 'name'], 'required'],
            [['id', 'brand_id', 'user_count', 'start_time', 'end_time', 'create_time'], 'integer'],
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
}
