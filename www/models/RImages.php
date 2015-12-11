<?php

namespace app\models;

use Yii;
use app\models\FCategory;
use yii\helpers\Html;
/**
 * This is the model class for table "r_images".
 *
 * @property integer $id
 * @property string $src
 */
class RImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_images';
    }

    /**
     * @inheritdoc
     */ 
    public function rules()
    {
        return [
            [['src'], 'required'],
            [['id'], 'integer'],
            [['src'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src' => 'Src',
        ];
    }

    public function beforeDelete()
    {
        if ((parent::beforeDelete()) and ($this->id != 1) and ($this->id != 2)) {
            
            $file = $this->src;

            if (file_exists($file))
                unlink($file); 
                
            return true;
        } else {
            return false;
        }
    }

    public function getImg()
    {
        return Html::img($this->src);
    }

}
