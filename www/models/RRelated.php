<?php

namespace app\models;

use Yii;
use app\models\FCategory;

/**
 * This is the model class for table "r_related".
 *
 * @property integer $id
 * @property integer $id_category
 * @property integer $id_related_category
 */
class RRelated extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_related';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category', 'id_related_category'], 'required'],
            [['id_category', 'id_related_category'], 'integer']
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
            'id_related_category' => 'Id Related Category',
        ];
    }

    public function getRelatedCategoryDetail()
    {
        return $this->hasOne(FCategory::className(), ['id' => 'id_related_category']);
    } 
}
