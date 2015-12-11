<?php

namespace app\models;

use Yii;
use app\models\SUnit;

/**
 * This is the model class for table "r_price".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $value
 * @property integer $id_unit
 */
class RPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'value', 'id_unit'], 'required'],
            [['id_item', 'value', 'id_unit'], 'integer'] 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_item' => 'Id Item',
            'value' => 'Value',
            'id_unit' => 'Id Unit',
        ];
    }

    public function getUnit()
    {
        return $this->hasOne(SUnit::className(), ['id' => 'id_unit']);
    }
}
