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

    /**
     * 通过UID获取绑定的用户
     *
     * @param $uid
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getUser($uid){
        $query = $this->find();

        $extra = $query->where(['uid'=>$uid])->one();

        if($extra){
            $user = (new Users())->find()->where(['id'=>$extra->user_id])->one();
            
            return $user;
        }else{
            return null;
        }
    }

    public function createBind($uid,$user_id){
        if(!$uid || !$user_id){
            return false;
        }
        //清除旧绑定
        $ole_extras = $this->find()->where(['user_id'=>$user_id])->orWhere(['uid'=>$uid])->all();
        if($ole_extras){
            foreach ($ole_extras as $v){
                $v->delete();
            }
        }

        $new_extra = new UsersExtra();
        $new_extra->type = 1;//微信
        $new_extra->uid = $uid;
        $new_extra->user_id = $user_id;
        $new_extra->create_time = time();

        if($new_extra->save()){
            return $new_extra;
        }else{
            return null;
        }
    }
}
