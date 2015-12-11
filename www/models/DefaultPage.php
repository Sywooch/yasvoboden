<?php

namespace app\models;

use Yii;

use app\models\RSettings;
use app\models\RImages;
use yii\base\Model;

/**
 * This is the model class for table "r_settings".
 *
 * @property integer $id
 * @property string $type
 * @property string $value
 */
class DefaultPage extends Model
{

    public $image_slider = false;
    public $category = false;
    public $preText = false;

    public function rules()
    {
        return [
           [['image_slider'], 'file'],
           [['preText'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'image_slider' => 'Слайдер',
            'preText' => 'Преимущества'
        ];
    }

    public function getImageSlider()
    {
        $imageSlider = RSettings::find()->where(['type' => 'imageSlider'])->all();

        return $imageSlider;
    }

    public function getCategories()
    {
        $categories = RSettings::find()->where(['type' => 'category'])->all();

        return $categories;
    }

    public function getPreTexts()
    {
        return RSettings::find()->where(['type' => 'preText'])->all();
    }

    public function addPreText()
    {
        if ($this->preText)
        {
            $RSettings = new RSettings();
            $RSettings->type = 'preText';
            $RSettings->value = $this->preText;
            $RSettings->save();
        }
    }

    public function addImageSlider()
    {
        if ($this->image_slider)
        {
            $dir = 'files/system/default_page/slider';
            if (!is_dir($dir))
                mkdir($dir);
            $dir .='/'.$this->image_slider->baseName.'.'.$this->image_slider->extension;
            $this->image_slider->saveAs($dir); 

            $image = new RImages();
            $image->src = $dir;
            $image->save();

            $RSettings = new RSettings();
            $RSettings->type = 'imageSlider';
            $RSettings->value = $image->id;
            $RSettings->save();
        }
    }
}
