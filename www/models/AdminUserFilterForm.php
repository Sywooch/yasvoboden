<?php

namespace app\models;

use Yii;
use app\models\FCity;
use app\models\FRegion;
use app\models\FOkrug;
use yii\base\Model;

class AdminUserFilterForm extends Model
{
	public $id_city = false;
	public $id_region = false;
	public $id_okrug = false;
	public $id_cat = false;

	public $search;
	public $search_field;

	public function rules()
    {
        return [
            [['id_city', 'id_okrug', 'id_region', 'id_cat'], 'integer'],
            [['search_field', 'search'], 'string']
        ];
    }

	 

	public function getGeoName()
	{
		$geo = new Geo();

		$geo->reset();
		$geo->installGeo($this->id_okrug, $this->id_region, $this->id_city);

		return $geo->name;
	}

	public function getCatName()
	{
		if ($this->id_cat)
		{
			$cat = FCategory::findOne($this->id_cat);
			return $cat->name;
		}
		else
			return "Выбрать";
	}

	public function setQuery($query)
	{
		$geo = new Geo();

		$geo->reset();
		$geo->installGeo($this->id_okrug, $this->id_region, $this->id_city);

		if ($geo->arrayCity)
			$where["id_city"] = $geo->arrayCity;

		if ($this->id_cat)
		{
			$cat = FCategory::findOne($this->id_cat);
			$arrayUsers = $cat->arrayUsers;

		
			$where["id"] = $arrayUsers;


		} 

		if (isset($where))
			$query = $query->where($where);

		if ($this->search != "")
			$query = $query->andWhere(["or like", $this->search_field, $this->search]);

		return $query;
	}
}
