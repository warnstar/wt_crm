<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sys_config".
 *
 * @property integer $id
 * @property string $name
 * @property string $key_name
 * @property string $key
 * @property integer $create_time
 */
class Sys_config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time'], 'integer'],
            [['name', 'key_name', 'key'], 'string', 'max' => 255]
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
            'key_name' => 'Key Name',
            'key' => 'Key',
            'create_time' => 'Create Time',
        ];
    }
}
