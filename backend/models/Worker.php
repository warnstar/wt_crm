<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "worker".
 *
 * @property integer $id
 * @property string $account_name
 * @property string $account_password
 * @property string $phone
 * @property integer $sex
 * @property integer $role_id
 * @property string $wchat
 * @property integer $brand_id
 * @property integer $area_id
 * @property integer $create_time
 */
class Worker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'worker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'role_id', 'brand_id', 'area_id', 'create_time'], 'integer'],
            [['role_id'], 'required'],
            [['account_name', 'account_password', 'phone', 'wchat'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_name' => 'Account Name',
            'account_password' => 'Account Password',
            'phone' => 'Phone',
            'sex' => 'Sex',
            'role_id' => 'Role ID',
            'wchat' => 'Wchat',
            'brand_id' => 'Brand ID',
            'area_id' => 'Area ID',
            'create_time' => 'Create Time',
        ];
    }
}
