<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $passport
 * @property integer $birth
 * @property string $phone
 * @property integer $sex
 * @property integer $status
 * @property integer $city_id
 * @property integer $area_id
 * @property string $wchat
 * @property integer $create_time
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nickname', 'passport'], 'required'],
            [['birth', 'sex', 'status', 'city_id', 'area_id', 'create_time'], 'integer'],
            [['nickname', 'passport', 'phone', 'wchat'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'passport' => 'Passport',
            'birth' => 'Birth',
            'phone' => 'Phone',
            'sex' => 'Sex',
            'status' => 'Status',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
            'wchat' => 'Wchat',
            'create_time' => 'Create Time',
        ];
    }



}
