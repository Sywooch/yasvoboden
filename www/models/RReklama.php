<?php

namespace app\models;

use Yii;

use yii\base\Model;
use yii\web\UploadedFile;


/**
 * This is the model class for table "r_reklama".
 *
 * @property integer $id
 * @property integer $image
 * @property integer $link
 */
class RReklama extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public $imageFile;

    public static function tableName()
    {
        return 'r_reklama';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['image'], 'integer'],
            [['imageFile'], 'file'],
            [['link'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'link' => 'Ссылка',
            'imageSrc' => 'Картинка',
            'imageFile' => 'Файл'
        ];
    }

    public function getImg()
    {
        return $this->hasOne(RImages::className(), ['id' => 'image']);
    }

    public function getImageSrc()
    {
        if ($this->img)
            return $this->img->src;
        else
            return false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))  
        {
            if ($this->imageFile)
            {
                if ($this->img)
                    $this->img->delete(); 

                $dir = 'files/system/reklama';
                if (!is_dir($dir))
                    mkdir($dir);
                $dir .='/'.$this->imageFile->baseName.'.'.$this->imageFile->extension;
                $this->imageFile->saveAs($dir); 

                $image = new RImages();
                $image->src = $dir;
                $image->save();

                $this->image = $image->id;
            }

            return true;
        }
        return false;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
                
            if ($this->img)
                $this->img->delete();
                
            return true;
        } else {
            return false;
        }
    }
}
