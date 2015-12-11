<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_type".
 *
 * @property integer $id
 * @property string $rus_name
 * @property string $name
 */
class SType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 's_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rus_name', 'name'], 'required'],
            [['rus_name', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rus_name' => 'Rus Name',
            'name' => 'Name',
        ];
    }
}
