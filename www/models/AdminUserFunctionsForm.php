<?php

namespace app\models;

use Yii;
use app\models\FCity;
use app\models\FRegion;
use app\models\FOkrug;
use yii\base\Model;

class AdminUserFunctionsForm extends Model
{
	public $id_user = false;
	public $addSum = false;

	public function rules()
    {
        return [
            [['id_user'], 'safe'],
            [['addSum'], 'integer']
        ];
    }



    public function addBalans()
    {
    	if ($this->id_user)
    	{
    		$users = User::find()->where(["id" => $this->id_user])->all();
    		//print_r($this->id_user);
    		foreach ($users as $user)
    		{
   				$user->scenario = "money";
    			$user->addMoney($this->addSum, 11);
    		}

    		$this->id_user = false;
    		$this->addSum = false;
    	}
    }

    public function load($post)
    {
    	if ($post["AdminUserFunctionsForm"]["id_user"])
    		foreach ($post["AdminUserFunctionsForm"]["id_user"] as $id_user)
    			$this->id_user[] = $id_user;

    	return parent::load($post);
    }
}
