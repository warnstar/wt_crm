<?php
namespace common\models;
use Yii;

/**
 * This is the model class for table "worker_extra".
 *
 * @property integer $id
 * @property integer $type
 * @property string $uid
 * @property integer $worker_id
 * @property integer $create_time
 */
class WorkerExtra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'worker_extra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'worker_id', 'create_time'], 'integer'],
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
            'worker_id' => 'Worker ID',
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
            $user = (new Worker())->find()->where(['id'=>$extra->uid])->one();
            return $user;
        }else{
            return null;
        }
    }
}
