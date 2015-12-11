<?php

namespace app\models;

use Yii;
use app\models\FCity;
use app\models\FRegion;
use app\models\FOkrug;
use yii\base\Model;

class Geo extends Model
{
	public $id_city = false;
	public $id_region = false;
	public $id_okrug = false;

	public function init()
	{
		$session = Yii::$app->session;

		if (isset($session["GEO"]["id_city"]))
			$this->id_city = $session["GEO"]["id_city"];

		if (isset($session["GEO"]["id_region"]))
			$this->id_region = $session["GEO"]["id_region"];

		if (isset($session["GEO"]["id_okrug"]))
			$this->id_okrug = $session["GEO"]["id_okrug"];
	}

	public function getCity()
	{
		if ($this->id_city)
			return FCity::findOne($this->id_city);
		else
			return false;
	}

	public function getRegion()
	{
		if ($this->id_region)
			return FRegion::findOne($this->id_region);
		else
			return false;
	}

	public function getOkrug()
	{
		if ($this->id_okrug)
			return FOkrug::findOne($this->id_okrug);
		else
			return false;
	}

	public function getName()
	{
		if ($this->id_city)
			return $this->getCity()->name;
		elseif ($this->id_region)
			return $this->getRegion()->name;
		elseif ($this->id_okrug)
			return $this->getOkrug()->name;
		else
			return "Выберите город";
	}

	public function setGeo($post)
	{

		if (isset($post["id_city"]))
			$this->id_city = $post["id_city"];

		if (isset($post["id_region"]))
			$this->id_region = $post["id_region"];

		if (isset($post["id_okrug"]))
			$this->id_okrug = $post["id_okrug"];

		$session = Yii::$app->session;

		$session["GEO"] = 
		[
			'id_city' => $this->id_city, 
			'id_region' => $this->id_region, 
			'id_okrug' => $this->id_okrug
		];
	}

	public function getArrayCity()
	{
		if ($city = $this->getCity())
			return $city->id;
		elseif ($region = $this->getRegion())
		{
			$cityes = $region->city;

			foreach ($cityes as $city) 
				$r_city[] = $city->id;
			
			return $r_city;
		}
		elseif ($okrug = $this->getOkrug()) 
		{
			$cityes = $okrug->city;

			foreach ($cityes as $city) 
				$r_city[] = $city->id;
			
			return $r_city;
		}
		else
			return false;
	}

	public function installGeo($id_okrug = false, $id_region = false, $id_city = false)
	{
		$this->id_okrug = $id_okrug;
		$this->id_region = $id_region;
		$this->id_city = $id_city;
	}

	public function reset()
	{
		$this->id_okrug = false;
		$this->id_region = false;
		$this->id_city = false;
	}


}
