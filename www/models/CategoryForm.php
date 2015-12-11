<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * LoginForm is the model behind the login form.
 */
class CategoryForm extends Model
{
    public $name;
    public $image;
    public $image_detail;
    public $bool_item;
    public $parent_id = false;
    public $image_src = false;
    public $image_detail_src = false;
    public $id = false;
    public $relatedCategory = false;
    public $sort;

    public function rules()
    {
        return [
            // username and password are both required
            [['name'], 'required'],
            [['image', 'image_detail'], 'file'],
            [['bool_item', 'image_src', 'image_detail_src', 'id', 'parent_id', 'relatedCategory', 'sort'], 'safe']
            // password is validated by validatePassword()
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'image' => 'Логотип',
            'image_detail' => 'Детальная картинка',
            'bool_item' => 'Конечный элемент'
        ];
    }


    public function save()
    {
        if (!$this->id)
            $category = new FCategory();
        else
            $category = FCategory::findOne($this->id);

        $category->name = $this->name;
        $category->sort = $this->sort;
        
        if ($this->parent_id)
            $category->parent_id = $this->parent_id;
        $category->save();

        if ($this->image)
        {
            $dir = 'files/system/categories/'.$category->id;
            if (!is_dir($dir))
                mkdir($dir);
            $dir .='/'.$this->image->baseName.'.'.$this->image->extension;
            $this->image->saveAs($dir); 

            $image = new RImages();
            $image->src = $dir;
            $image->save();

            $category->image = $image->id;
        }

        if ($this->image_detail)
        {
            $dir = 'files/system/categories/'.$category->id;
            if (!is_dir($dir))
                mkdir($dir);
            $dir .='/'.$this->image_detail->baseName.'.'.$this->image_detail->extension;
            $this->image_detail->saveAs($dir); 

            $image = new RImages();
            $image->src = $dir;
            $image->save();

            $category->image_detail = $image->id;
        }

        $category->bool_item = $this->bool_item;

        $category->save();
    }

    public function loadCategory($id)
    {
        $category = FCategory::findOne($id);

        $this->name = $category->name;
        $this->id = $category->id;
        $this->parent_id = $category->parent_id;
        $this->bool_item = $category->bool_item;
        $this->image_src = $category->images->src;
        $this->image_detail_src = $category->imagesDetail->src;
        $this->sort = $category->sort;

        $this->relatedCategory = $category->relatedCategory;
    }

    public function getParentText()
    {
        $category = FCategory::findOne($this->id);

        if (isset($category->parent))
            return $category->parent->name;
        else
            return 'Выбрать';
    }
    
}
