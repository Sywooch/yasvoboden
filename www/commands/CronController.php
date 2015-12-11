<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\RActiveItems;
use app\models\User;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CronController extends Controller
{
    
	public function actionIndex()
    {
    	$this->resetActiveItems();
    	$this->deleteUsers();
    }

    public function resetActiveItems()
    {
    	$time = time();

    	$RActiveItems = RActiveItems::find()->where(['<=', 'date', $time])->all();
    	if ($RActiveItems)
    		foreach($RActiveItems as $item)
    			$item->delete();
    }

    public function deleteUsers()
    {
    	$time = time();
    	$time = $time - (60*60*24*3);

    	$query = User::find()->where(['active' => 1]);
    	$query = $query->andWhere(['<=', 'date_created', $time]);

    	$users = $query->all();

    	if ($users)
    		foreach ($users as $user) 
    			$user->delete();
    }

    


}
