<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "festival".
 *
 * @property string $id
 * @property string $name
 * @property integer $start_time
 * @property string $greetings
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
            [['id', 'name', 'start_time', 'greetings'], 'required'],
            [['id', 'start_time'], 'integer'],
            [['name', 'greetings'], 'string', 'max' => 255]
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
            'greetings' => 'Greetings',
        ];
    }
}
