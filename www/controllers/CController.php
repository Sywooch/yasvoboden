<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\RItems;
use app\models\FOkrug;
use app\models\FRegion;
use app\models\FCity;
use app\models\Geo;
use app\models\LoginForm;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\ForgoutForm;

class CController extends Controller
{
	public $geo;
	public $loginForm;

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ["logout"],
                'denyCallback' => function ($rule, $action) {
                                    $this->redirect(['site/index', "auth" => "on"]);
                                },
                'rules' => [
                    [
                        'actions' => ["logout"],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

	public function init()
	{
		$session = Yii::$app->session;
		//Yii::$app->user->logout();
		if ($session->isActive)
			$session->open();
		
		$post = Yii::$app->request->post(); 
		$this->geo = new Geo(); 
		
		if (isset($post["setCity"]))
			$this->geo->setGeo($post);

		$this->loginForm = new LoginForm();
		if (Yii::$app->request->post("auth"))
		{
			$this->loginForm->load(Yii::$app->request->post());
			$this->loginForm->login();
		}

		Yii::$app->view->params['countItems'] = RItems::find()->isActive()->city($this->geo)->count();
		Yii::$app->view->params['city'] = $this->geo->getName();
	}

	public function actionModalCity()
	{
		$okrugs = FOkrug::find()->orderBy('sort, name')->all();

		if ($okrug = $this->geo->getOkrug())
			$regions = $okrug->region;
		else
			$regions = false;

		if ($region = $this->geo->getRegion())
			$cityes = $region->city;
		else
			$cityes  = false;

		return $this->renderPartial('modal', ['okrugs' => $okrugs, 'regions' => $regions, 'cityes' => $cityes]);
	}

	public function actionRegions()
	{
		$session = Yii::$app->session;

		if (isset($_REQUEST["id_okrug"]))
			$id_okrug = $_REQUEST["id_okrug"];
		else
			$id_okrug = 0;

		$regions = FRegion::find()->where(['id_okrug' => $id_okrug])->orderBy('sort, name')->all();
		return $this->renderPartial('regions', ['regions' => $regions]);
	}

	public function actionCityes()
	{
		$session = Yii::$app->session;

		if (isset($_REQUEST["id_region"]))
			$id_region = $_REQUEST["id_region"];
		else
			$id_region = 0;

		$cityes = FCity::find()->where(['id_region' => $id_region])->orderBy('sort, name')->all();
		return $this->renderPartial('cityes', ['cityes' => $cityes]);
	}

	public function auth()
	{
		$user = Yii::$app->user;
		$loginForm = $this->loginForm;

		if ($user->isGuest)
		{
			$ForgoutForm = new ForgoutForm();
			$loginForm = $this->loginForm;
			return $this->renderPartial('@app/views/c/auth.php', ['loginForm' => $loginForm, 'ForgoutForm' => $ForgoutForm]);
		}
		else
		{
			$user = User::findOne($user->id);
			return $this->renderPartial('@app/views/c/user_panel.php', ['user' => $user]);
		} 
	}

	public function getColorLine()
	{
		$user = Yii::$app->user;

		if ($user->isGuest)
			return "red";
		else
			return "green";
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goBack();
	}

	public function actionAuthAjax()
	{
		$post["LoginForm"] = Yii::$app->request->post();
		$this->loginForm->load($post);

		return $this->loginForm->loginAjax(); 
	}

	public function actionForgoutAjax()
	{
		$post["ForgoutForm"] = Yii::$app->request->post();
		
		$ForgoutForm = new ForgoutForm();

		$ForgoutForm->load($post);

		return $ForgoutForm->sendForgout(); 
	}

	public function actionYmap($coord)
	{
		$coord = explode(",", $coord);
		$x = $coord[0];
		$y = $coord[1];
		return $this->renderPartial('ymap', ['x' => $x, 'y' => $y]);
	}

}