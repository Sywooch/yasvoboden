<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_black_word".
 *
 * @property integer $id
 * @property string $value
 */
class SBlackWord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 's_black_word';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Значение',
        ];
    }
}
