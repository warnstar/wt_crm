<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_extra".
 *
 * @property integer $id
 * @property integer $type
 * @property string $uid
 * @property integer $user_id
 * @property integer $create_time
 */
class UsersExtra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_extra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'create_time'], 'integer'],
            [['uid'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'uid' => 'Uid',
            'user_id' => 'User ID',
            'create_time' => 'Create Time',
        ];
    }
    public function getUser($uid){
        $query = $this->find();

        $extra = $query->where(['uid'=>$uid])->one();
        if($extra){
            $user = (new Users())->find()->where(['id'=>$extra->uid])->one();
            return $user;
        }else{
            return null;
        }
    }
}
