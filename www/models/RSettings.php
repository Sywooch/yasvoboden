<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "r_settings".
 *
 * @property integer $id
 * @property string $type
 * @property string $value
 */
class RSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
            [['type'], 'string', 'max' => 255],
            [['value'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'value' => 'Value',
        ];
    }

    public function getImage()
    {
        return $this->hasOne(RImages::className(), ['id' => 'value']);
    }

    public function getCategory()
    {
        return $this->hasOne(FCategory::className(), ['id' => 'value']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
                
            if ($this->type == 'imageSlider')
            {
                $this->image->delete();
            }
                
            return true;
        
        } else {
            return false;
        }
    }
}
