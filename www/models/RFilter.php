<?php

namespace app\models;

use Yii;
use app\models\FFields;
use app\models\SSelect;

/**
 * This is the model class for table "r_filter".
 *
 * @property integer $id
 * @property integer $id_category
 * @property integer $id_field
 */
class RFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category', 'id_field'], 'required'],
            [['id_category', 'id_field'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_category' => 'Id Category',
            'id_field' => 'Id Field',
        ];
    }

    public function getFilterValues()
    {
        $field = FFields::findOne($this->id_field);

        $r = array();

        if ($field->typeLink->name == "select")
        {
            $r = $this->hasMany(SSelect::className(), ['id_field' => 'id_field']);
        }

        return $r;
    }
}
