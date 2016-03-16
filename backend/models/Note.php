<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note".
 *
 * @property integer $id
 * @property integer $visit_id
 * @property integer $mgu_id
 * @property integer $type
 * @property string $content
 * @property integer $content_type
 * @property string $notify_user
 * @property integer $general_note_type
 * @property integer $worker_id
 * @property integer $create_time
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visit_id', 'mgu_id', 'type', 'content_type', 'general_note_type', 'worker_id', 'create_time'], 'integer'],
            [['mgu_id', 'type', 'content_type'], 'required'],
            [['content'], 'string'],
            [['notify_user'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visit_id' => 'Visit ID',
            'mgu_id' => 'Mgu ID',
            'type' => 'Type',
            'content' => 'Content',
            'content_type' => 'Content Type',
            'notify_user' => 'Notify User',
            'general_note_type' => 'General Note Type',
            'worker_id' => 'Worker ID',
            'create_time' => 'Create Time',
        ];
    }
}
