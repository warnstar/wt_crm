<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medical_group_user".
 *
 * @property integer $id
 * @property integer $medical_group_id
 * @property integer $user_id
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $create_time
 */
class Medical_group_user extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medical_group_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medical_group_id', 'user_id'], 'required'],
            [['medical_group_id', 'user_id', 'start_time', 'end_time', 'create_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medical_group_id' => 'Medical Group ID',
            'user_id' => 'User ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'create_time' => 'Create Time',
        ];
    }


}
