<?php

namespace app\models;

use Yii;
use app\models\RItems;

/**
 * This is the model class for table "r_bad_record".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $count
 * @property integer $date
 */
class RBadRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_bad_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'count', 'date'], 'required'],
            [['id_item', 'count', 'date'], 'integer']
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
            'count' => 'Count',
            'date' => 'Date',
        ];
    }

    public function addRecord()
    {
        $this->date = time();
        $this->count = $this->count + 1;

        $this->save();
    }

    public function getRecord()
    {
        return $this->hasOne(RItems::className(), ['id' => 'id_item']);
    }

    public function getDateText()
    {
        return date("d.m.Y H:i", $this->date);
    }
}
