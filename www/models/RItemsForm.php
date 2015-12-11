<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * LoginForm is the model behind the login form.
 */
class RItemsForm extends Model
{
    public $name;
    public $id_category;
    public $field; 
    public $image;
    public $price;
    public $id_city = false;
    public $text;
    public $phone;

    private $id_user;
    private $id_item = false;

    public function init()
    {
        $user = Yii::$app->user->identity;
        $this->id_user = $user->id;

        if ($this->id_city == false)
            $this->id_city = $user->id_city;
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название записи',
            'text' => 'Текст записи',
            'id_city' => 'Город',
            'phone' => 'Телефон',
            'price' => 'Цена',
            'field' => 'Поле',
            'image' => 'Фото', 
        ];
    }
   

    public function rules()
    {
        return [
            [['id_city'], 'integer'],
            [['id_city', 'name', 'text', 'phone'], 'required'],
            [['name'], 'string'],
            [['image', 'price', 'text', 'phone', 'field'], 'safe'],
        ];
    }

    public function getCityName()
    {
        if ($this->id_city)
        {
            $city = FCity::findOne($this->id_city);
            return $city->name;
        }
        else
            return "Выбрать";
    }

    public function getError($attribut, $input = true)
    {
        if (isset($this->errors[$attribut]))
            if ($input)
                return 'inputError';
            else
                return 'blockError';
    }

    public function getImages()
    {
        if (!$this->id_item)
            $result = RImages::find()->where(["id" => 1])->all();
        else
            $result = RImages::find()->where(["id_item" => $this->id_item])->all();

        return $result;
    }

    public function getTypesPrice()
    {
        return SUnit::find()->where(['id_category' => $this->id_category])->all();
    }

    public function getTypesField()
    {
        return FFields::find()->where(['id_category' => $this->id_category])->orderBy('sort, name')->all();
    }

    public function save()
    {
        if (!$this->id_item)
        {
            $RItems = new RItems();
            $RItems->date = time();
        }
        else
            $RItems = RItems::findOne($this->id_item);

        $RItems->id_user = $this->id_user;
        $RItems->id_city = $this->id_city;
        $RItems->phone = $this->phone;
        
        $RItems->description = $this->text;
        $RItems->name = $this->name;
        $RItems->id_parent = $this->id_category;

        $RItems->save();

        $this->id_item = $RItems->id;

        if ($this->price)
            foreach ($this->price as $id_unit => $value)
                $this->priceSave($id_unit, $value); 

        if ($this->field)
            foreach ($this->field as $id_field => $value) 
                $this->fieldSave($id_field, $value);

        if ($this->image)
            foreach ($this->image as $image)
                $this->saveImage($image);
    }

    private function priceSave($id_unit, $value)
    {
        $RPrice = RPrice::findOne(["id_item" => $this->id_item, "id_unit" => $id_unit]);

        if (!$RPrice)
            $RPrice = new RPrice();

        $RPrice->id_item = $this->id_item;
        $RPrice->id_unit = $id_unit;
        $RPrice->value = $value;

        $RPrice->save();
    }


    private function fieldSave($id_field, $value)
    {
        $RFields = RFields::findOne(["id_item" => $this->id_item, "id_field" => $id_field]);

        if (!$RFields)
            $RFields = new RFields();

        $RFields->id_item = $this->id_item;
        $RFields->id_field = $id_field;
        $RFields->value = $value;

        $RFields->save();
    }

    private function saveImage($image)
    {
        $dir = 'files/items/'.$this->id_category;
        
        if (!is_dir($dir))
            mkdir($dir);

        $dir .='/'.$image->baseName.'.'.$image->extension;
        $image->saveAs($dir); 

        $rimage = new RImages();

        $rimage->id_item = $this->id_item;
        $rimage->src = $dir;
        $rimage->save();
    }

    public function loadForm($item)
    {
        $this->id_item = $item->id;
        $this->name = $item->name;
        $this->text = $item->description;
        $this->phone = $item->phone;
        $this->id_category = $item->id_parent;
        $this->id_city = $item->id_city;

        $this->id_user = $item->id_user;
        $this->price = $this->prices;
        $this->field = $this->fields;
    }

    public function getPrices()
    {
        $RPrice = RPrice::find()->where(["id_item" => $this->id_item])->all();

        $result = false;
        foreach ($RPrice as $price) 
            $result[$price->id_unit] = $price->value;

        return $result;
    }

    public function getFields()
    {
        $RFields = RFields::find()->where(["id_item" => $this->id_item])->all();

        $result = false;

        foreach ($RFields as $field)
            $result[$field->id_field] = $field->value;

        return $result;
    }
}
