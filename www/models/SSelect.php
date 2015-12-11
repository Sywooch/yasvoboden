<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_select".
 *
 * @property integer $id
 * @property integer $id_field
 * @property string $value
 */
class SSelect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 's_select';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_field', 'value'], 'required'],
            [['id_field'], 'integer'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_field' => 'Id Field',
            'value' => 'Значение',
        ];
    }
}
