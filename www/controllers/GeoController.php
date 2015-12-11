<?php

namespace app\controllers;

use Yii;
use app\models\FOkrug;
use app\models\FRegion;
use app\models\FCity;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * ReklamaController implements the CRUD actions for RReklama model.
 */
class GeoController extends AdminController
{
    public function actionIndex()
    {
       $FOkrug = FOkrug::find()->orderBy('sort, name')->all();

       return $this->render('index', ['okrugs' => $FOkrug]); 
    }

   public function actionDeleteOkrug()
   {
   		$post = Yii::$app->request->post();

        $id_element = $post["id_element"];

        $okrug = FOkrug::findOne($id_element);
        
        $okrug->delete();

        $this->redirect(['/geo/index']); 
   }

   public function actionCreateOkrug()
   {
   		$model = new FOkrug();

    	if (Yii::$app->request->isPost) 
    	{
    		 $post = Yii::$app->request->post();

    		 $model->load($post);

    		 if ($model->validate())
    		 {
    		 	$model->save();
    		 	$this->redirect(['geo/index']);
    		 }
    	}

    	return $this->render('createOkrug', ['model' => $model]);
   }

   public function actionEditOkrug($id)
   {
   		$model = FOkrug::findOne($id);

    	if (Yii::$app->request->isPost) 
    	{
    		 $post = Yii::$app->request->post();

    		 $model->load($post);

    		 if ($model->validate())
    		 {
    		 	$model->save();
    		 	$this->redirect(['geo/index']);
    		 }
    	}

    	return $this->render('editOkrug', ['model' => $model]); 
   }

	public function actionIndexRegion($id)
	{
		$FRegion = FRegion::find()->where(["id_okrug" => $id])->orderBy('sort, name')->all();
		$FOkrug = FOkrug::findOne($id);

		return $this->render('indexRegion', ['regions' => $FRegion, 'okrug' => $FOkrug]); 
	}

	public function actionCreateRegion($id)
	{
		$model = new FRegion();
		$model->id_okrug = $id;

		if (Yii::$app->request->isPost) 
		{
			 $post = Yii::$app->request->post();

			 $model->load($post);

			 if ($model->validate())
			 {
			 	$model->save();
			 	$this->redirect(['geo/index-region', "id" => $id]);
			 }
		}

		return $this->render('createRegion', ['model' => $model]);
	}

	public function actionDeleteRegion()
	{
		$post = Yii::$app->request->post();

	    $id_element = $post["id_element"];

	    $region = FRegion::findOne($id_element);

	    $id_parent = $region->id_okrug;
	    
	    $region->delete();

	    $this->redirect(['/geo/index-region', "id" => $id_parent]); 
	}

	public function actionEditRegion($id)
	{
		$model = FRegion::findOne($id);

		if (Yii::$app->request->isPost) 
		{
			 $post = Yii::$app->request->post();

			 $model->load($post);

			 if ($model->validate())
			 {
			 	$model->save();
			 	$this->redirect(['geo/index-region', "id" => $model->id_okrug]);
			 }
		}

		return $this->render('editRegion', ['model' => $model]);
	}

	public function actionIndexCity($id)
	{
		$FCity = FCity::find()->where(["id_region" => $id])->orderBy('sort, name')->all();
		$FRegion = FRegion::findOne($id);

		return $this->render('indexCity', ['cityes' => $FCity, 'region' => $FRegion]); 
	}

	public function actionCreateCity($id)
	{
		$model = new FCity();
		$model->id_region = $id;

		if (Yii::$app->request->isPost) 
		{
			 $post = Yii::$app->request->post();

			 $model->load($post);

			 if ($model->validate())
			 {
			 	$model->save();
			 	$this->redirect(['geo/index-city', "id" => $id]);
			 }
		}

		return $this->render('createCity', ['model' => $model]);
	}

	public function actionDeleteCity()
	{
		$post = Yii::$app->request->post();

	    $id_element = $post["id_element"];

	    $city = FCity::findOne($id_element);

	    $id_parent = $city->id_region;
	    
	    $city->delete();

	    $this->redirect(['/geo/index-city', "id" => $id_parent]); 
	}

	public function actionEditCity($id)
	{
		$model = FCity::findOne($id);

		if (Yii::$app->request->isPost) 
		{
			 $post = Yii::$app->request->post();

			 $model->load($post);

			 if ($model->validate())
			 {
			 	$model->save();
			 	$this->redirect(['geo/index-city', "id" => $model->id_region]);
			 }
		}

		return $this->render('editCity', ['model' => $model]);
	}
}
