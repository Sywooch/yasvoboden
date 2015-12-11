<?php

namespace app\models;

use Yii;
use app\models\FRegion;
use app\models\FOkrug;

/**
 * This is the model class for table "f_okrug".
 *
 * @property integer $id
 * @property string $name
 */
class FOkrug extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'f_okrug';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => 'Название',
        ];
    }

    public function getCity()
    {
        return $this->hasMany(FCity::className(), ['id_region' => 'id'])->viaTable('f_region', ['id_okrug' => 'id']);
    }

    public function getRegion()
    {
        return $this->hasMany(FRegion::className(), ['id_okrug' => 'id']);   
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
                
            if ($this->region)
                foreach ($this->region as $region)
                    $region->delete();
                
            return true;
        } else {
            return false;
        }
    }
}
