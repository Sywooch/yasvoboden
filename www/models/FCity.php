<?php

namespace app\models;

use Yii;
use app\models\FRegion;
use app\models\RItems;

/**
 * This is the model class for table "f_city".
 *
 * @property integer $id
 * @property integer $id_region
 * @property string $name
 */
class FCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'f_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_region', 'name'], 'required'],
            [['id_region'], 'integer'],
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
            'id_region' => 'Id Region',
            'name' => 'Название',
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(FRegion::className(), ['id' => 'id_region']);
    }

    public function getItems()
    {
        return $this->hasMany(RItems::className(), ['id_city' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_city' => 'id']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
                
            if ($this->items)
                foreach ($this->items as $item)
                    $item->delete();

            if ($this->users)
                foreach ($this->users as $user)
                    $user->delete();
                
            return true;
        } else {
            return false;
        }
    }
}
