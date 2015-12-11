<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "r_activate_weeks_item".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $week
 * @property integer $time
 * @property integer $status
 */
class RActivateWeeksItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_activate_weeks_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'week', 'time'], 'required'],
            [['id_item', 'week', 'status'], 'integer']
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
            'week' => 'Week',
            'time' => 'Time',
            'status' => 'Status',
        ];
    }
}
