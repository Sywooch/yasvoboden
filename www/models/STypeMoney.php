<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_type_money".
 *
 * @property integer $id
 * @property string $name
 * @property string $rus_name
 */
class STypeMoney extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 's_type_money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rus_name'], 'required'],
            [['name', 'rus_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'rus_name' => 'Rus Name',
        ];
    }
}
