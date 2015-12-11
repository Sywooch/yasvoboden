<?php

namespace app\models;

use Yii;
use app\models\FOkrug;
use app\models\FCity;

/**
 * This is the model class for table "f_region".
 *
 * @property integer $id
 * @property integer $id_okrug
 * @property string $name
 */
class FRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'f_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_okrug', 'name'], 'required'],
            [['id_okrug'], 'integer'],
            [['name'], 'string', 'max' => 500],
            [['sort'], 'integer'],
            ['sort', 'default', 'value' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_okrug' => 'Id Okrug',
            'name' => 'Название',
        ];
    }

    public function getOkrug()
    {
        return $this->hasOne(FOkrug::className(), ['id' => 'id_okrug']);
    }

    public function getCity()
    {
        return $this->hasMany(FCity::className(), ['id_region' => 'id']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
                
            if ($this->city)
                foreach ($this->city as $city)
                    $city->delete();
                
            return true;
        } else {
            return false;
        }
    }
}
