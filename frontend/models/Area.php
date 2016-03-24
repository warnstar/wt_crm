<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property string $area_name
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_name'], 'required'],
            [['area_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area_name' => 'Area Name',
        ];
    }
}
