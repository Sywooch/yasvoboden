<?php

namespace app\models;

use Yii;
use app\models\RImages;
use yii\helpers\Url;
use app\models\RRelated;
use app\models\RItems;
use app\models\RFilter;
use app\models\Geo;
use app\models\FPriceCategory;
use yii\helpers\ArrayHelper;
use app\models\SUnit;
/**
 * This is the model class for table "f_category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property integer $image
 */
class FCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'f_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'image'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
            'parent_id' => 'Parent ID',
            'name' => 'Название',
            'image' => 'Image',
            'sort' => 'Сортировка'
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
                
            if ($this->images)
            	$this->images->delete();

            if ($this->imagesDetail)
            	$this->imagesDetail->delete();

            if ($this->relatedCategory)
                foreach ($this->relatedCategory as $rel)
                    $rel->delete();

            if ($this->relatedCategoryThis)
                foreach ($this->relatedCategoryThis as $rel)
                    $rel->delete();

            if ($this->items)
                foreach ($this->items as $item)
                    $item->delete();

            if ($this->priceCategory)
                    $this->priceCategory->delete(); 

            if ($this->filters)
                foreach ($this->filters as $filter)
                    $filter->delete();

            if ($this->typesPrice)
                foreach ($this->typesPrice as $price)
                    $price->delete();

            if ($this->childrens)
                foreach ($this->childrens as $children)
                    $children->delete();

            return true;
        } else {
            return false;
        }
    }

    public function getImages()
    {
        return $this->hasOne(RImages::className(), ['id' => 'image']);
    }

    public function getImagesDetail()
    {
        return $this->hasOne(RImages::className(), ['id' => 'image_detail']);
    }

    public function getUrl($bread = false, $param = "")
    {
        if ($bread == false)
        {
            if ($this->bool_item == 0)
                $url = Url::toRoute(['/site/index', 'cat' => $this->id]);
            else
                $url = Url::toRoute(['/site/items', 'cat' => $this->id]);

            $res = $url; 
        }
        else
        {
            if ($this->bool_item == 0)
                $url = 'site/index';
            else
                $url = 'site/items';

            $res = $url;
        }

        return $res;
    }

    public function getBrandChumbs()
    {
        $parent_id = $this->parent_id;
       
        $res = array();
        while ($parent = FCategory::findOne($parent_id))
        {
            $res[] = array("name" => $parent->name, "url" => $parent->getUrl(true), "id" => $parent->id);
            $parent_id = $parent->parent_id;
        }

        if (count($res) > 0)
            $res = array_reverse($res);
        
        return $res;

    }

    public function getItems()
    {
        return $this->hasMany(RItems::className(), ['id_parent' => 'id']); 
    }

    public function getChildrens()
    {
        return $this->hasMany(FCategory::className(), ['parent_id' => 'id']);
    }


    public function getRelatedCategory()
    {
        return $this->hasMany(RRelated::className(), ['id_category' => 'id']);
    }

    public function getRelatedCategoryThis()
    {
        return $this->hasMany(RRelated::className(), ['id_related_category' => 'id']);
    }

    public function getCountItems()
    {
        $count = 0;

        $geo = new Geo();
        $children_cat = FCategory::find()->where(['parent_id' => $this->id])->all();

        if (count($children_cat) > 0)
            foreach ($children_cat as $category) 
                $count += $category->countItems;
        

        $countItems = RItems::find()->where(["id_parent" => $this->id])->isActive()->city($geo)->count();

        $count += $countItems;

        return $count;

    }

    public function getPriceCategory()
    {
        return $this->hasOne(FPriceCategory::className(), ['id_category' => 'id']);
    }

    public function getFilters()
    {
        return $this->hasMany(RFilter::className(), ['id_category' => 'id']);
    }

    public function getFields()
    {
        return $this->hasMany(FFields::className(), ['id_category' => 'id'])->orderBy('sort, name');
    }

    public function getSelectFields()
    {
        return $this->hasMany(FFields::className(), ['id_category' => 'id'])->joinWith('typeLink')->where(["s_type.name" => "select"])->orderBy('sort, name');
    }

    public function getParent()
    {
        return $this->hasOne(FCategory::className(), ['id' => 'parent_id']);
    }

    public function getTypesPrice()
    {
        return $this->hasMany(SUnit::className(), ['id_category' => 'id']);
    }

    public function is_rel($id)
    {
        $r = RRelated::findOne(['id_category' => $this->id, 'id_related_category' => $id]);

        if ($r)
            return true;
        else
            return false;
    }

    public function getAdminUrl($bread = false, $param = "")
    {
        if ($this->bool_item == 0)
            $url = Url::toRoute(['/cabinet/index', 'id' => $this->id]);
        else
            $url = Url::toRoute(['/cabinet/item', 'id' => $this->id]);

        $res = $url; 

        return $res;
    }

    public function installFilter($id_field)
    {
        if ($this->filters)
            foreach ($this->filters as $filter)
                $filter->delete();

        if ($id_field != 0)
        {
            $r_filter = new RFilter();

            $r_filter->id_category = $this->id;
            $r_filter->id_field = $id_field;
            $r_filter->save();
        }

    }

    public function getActiveFilter()
    {
        if ($this->filters)
            return $this->filters[0]->id_field;
        else
            false;
    }

    public function getArrayUsers()
    {
        if ($this->bool_item == 1)
        {
            $items = RItems::find()->where(['id_parent' => $this->id])->all();

            foreach ($items as $item) 
                $id_user[] = $item->id_user;
        }
        else
        {
            $cats = FCategory::find()->where(['parent_id' => $this->id])->all();
            $id_user = array();    
                foreach ($cats as $cat) 
                    if ($cat->arrayUsers)
                        $id_user = ArrayHelper::merge($id_user, $cat->arrayUsers);
        }

        if (isset($id_user) and count($id_user) > 0)
            return $id_user;
        else
            return false;
    }
}
 