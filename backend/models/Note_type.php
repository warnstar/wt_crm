<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $create_time
 */
class Note_type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_time'], 'integer'],
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
            'create_time' => 'Create Time',
        ];
    }
}
