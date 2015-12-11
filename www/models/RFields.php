<?php

namespace app\models;

use Yii;
use app\models\FFields;
use app\models\SSelect;
use app\models\RItems; 

/**
 * This is the model class for table "r_fields".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $id_field
 * @property string $value
 */
class RFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'id_field', 'value'], 'required'],
            [['id_item', 'id_field'], 'integer'],
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
            'id_item' => 'Id Item',
            'id_field' => 'Id Field',
            'value' => 'Value',
        ];
    }

    public function getTypeField()
    {
        return $this->hasOne(FFields::className(), ['id' => 'id_field']);
    }

    public function getVal()
    {
        $type_field = $this->typeField->typeLink->name;

        switch ($type_field) 
        {
            case 'integer':
                $r = $this->value;
                break;
            
            case 'select':
                $r = SSelect::findOne($this->value);
                $r = $r->value;
                break;
            case 'yandex_map':
                $r = \Yii::$app->view->renderFile('@app/views/c/map.php', ['field' => $this]);;
                break;

            default:
                $r = $this->value;
                break;
        }

        return $r;
    }


    public function getItems()
    {
        return $this->hasOne(RItems::className(), ['id' => 'id_item']);
    }
}
