<?php

namespace app\models;

use Yii;
use app\models\FCity;
use app\models\FRegion;
use app\models\FOkrug;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SearchForm extends Model
{
	public $search;

	public function rules()
    {
        return [
            [['search'], 'string']
        ];
    }


    public function setQuery($query)
    {
    	if ($this->search != "")
    	{
    		$search = explode(" ", $this->search);
    	
    		$query = $query->where(['or like', 'r_items.name', $search]);
    		$query = $query->orWhere(['or like', 'r_items.description', $search]);

    		$query = $query->joinWith('fields')->orWhere(['or like', 'r_fields.value', $search]);

            $s_select = SSelect::find()->where(["or like", "value", $search])->all();

            if (count($s_select) > 0)
            {
                foreach ($s_select as $select) 
                    $query = $query->orWhere("(`r_fields`.`id_field` = ".$select->id_field." AND `r_fields`.`value` = ".$select->id.")");
            }
    	}
    	else
    	{
    		$query = $query->where(["r_items.id" => ""]);
    	}

    	return $query;
    }

}
