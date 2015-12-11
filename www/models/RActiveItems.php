<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "r_active_items".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $date
 */
class RActiveItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_active_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'date'], 'required'],
            [['id_item', 'date'], 'integer']
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
            'date' => 'Date',
        ];
    }
}
