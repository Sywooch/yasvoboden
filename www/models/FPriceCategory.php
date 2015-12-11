<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "f_price_category".
 *
 * @property integer $id
 * @property integer $id_category
 * @property integer $price
 */
class FPriceCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'f_price_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category'], 'required'],
            [['id_category', 'price', 'time', 'timeText'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_category' => 'Id Category',
            'price' => 'Price',
        ];
    }

    public function getTimeText()
    {
        return $this->time/3600;
    }

    public function setTimeText($value)
    {
        $this->time = $value * 3600;
    }
}
