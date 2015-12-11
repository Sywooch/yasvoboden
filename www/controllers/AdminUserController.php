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
use app\models\User;
use app\models\Geo;
use app\models\FCategory;
use app\models\AdminUserFilterForm;
use app\models\AdminUserFunctionsForm;
use phpoffice\phpexcel;

/**
 * ReklamaController implements the CRUD actions for RReklama model.
 */
class AdminUserController extends AdminController
{
    public function actionIndex()
    {
		$get = Yii::$app->request->get(); 
		$post = Yii::$app->request->post();
		$query = User::find();

		$filterForm = new AdminUserFilterForm();
		$filterForm->load($get);
		$query = $filterForm->setQuery($query);

		$search_field = [
			'r_users.id' => 'ID',
			'r_users.surname' => 'Фамилия',
			'r_users.login' => 'Логин',
			'r_users.phone' => 'Телефон',
			'r_users.email' => 'email'
		];

		$functionsForm = new AdminUserFunctionsForm();

		if (isset($post["addBalans"]))
		{
			$functionsForm->load($post);
			$functionsForm->addBalans();
		}

		if (isset($get["sort"]))
		{
			$sort = $get["sort"];

			$query->joinWith(['city.region.okrug']);
			$query->orderBy($sort);
		}


		$users = $query->all();

		if (isset($post["saveReport"]))
		{
			$this->saveExel($users);
		}

		return $this->render('index', ['users' => $users, 'filterForm' => $filterForm, 'functionsForm' => $functionsForm, 'search_field' => $search_field]);
    }

    public function actionModalGeo()
	{
		$okrugs = FOkrug::find()->all();

		if ($okrug = $this->geo->getOkrug())
			$regions = $okrug->region;
		else
			$regions = false;

		if ($region = $this->geo->getRegion())
			$cityes = $region->city;
		else
			$cityes  = false;

		return $this->renderPartial('modalGeo', ['okrugs' => $okrugs, 'regions' => $regions, 'cityes' => $cityes]);
	}

	public function actionModalCategory()
    {
    	$FCategory = FCategory::find()->where(['parent_id' => 0])->all();

    	return $this->renderPartial('modalCategory', ['category' => $FCategory]);
    }

    public function actionModalPodCategory()
    {
        $post = Yii::$app->request->post();

        $id = $post["id_category"];
        $query = FCategory::find()->where(['parent_id' => $id]);
        $FCategory = $query->all();
       
        if ($query->count() == 0)
            return "no";
        else
            return $this->renderPartial('modalPodCategory', ['category' => $FCategory]);
    }

    public function saveExel($users)
    {
    	$phpexcel = new \PHPExcel(); // Создаём объект PHPExcel
		/* Каждый раз делаем активной 1-ю страницу и получаем её, потом записываем в неё данные */
		$page = $phpexcel->setActiveSheetIndex(0); // Делаем активной первую страницу и получаем её
		
		$page->setCellValue("A1", "ID");
		$page->setCellValue("B1", "Фамилия Имя");
		$page->setCellValue("C1", "Логин");
		$page->setCellValue("D1", "Email");
		$page->setCellValue("E1", "Телефон");
		$page->setCellValue("F1", "Баланс");
		$page->setCellValue("G1", "Округ");
		$page->setCellValue("H1", "Регион");
		$page->setCellValue("I1", "Город");
		$page->setCellValue("J1", "Всего обьявлений");
		$page->setCellValue("K1", "Активных обьявлений");

		$i = 2;
		foreach ($users as $user)
		{
			$page->setCellValue("A".$i, $user->id);
			$page->setCellValue("B".$i, $user->surname." ".$user->name);
			$page->setCellValue("C".$i, $user->login);
			$page->setCellValue("D".$i, $user->email);
			$page->setCellValue("E".$i, $user->phone);
			$page->setCellValue("F".$i, $user->money);
			$page->setCellValue("G".$i, $user->city->region->okrug->name);
			$page->setCellValue("H".$i, $user->city->region->name);
			$page->setCellValue("I".$i, $user->city->name);
			$page->setCellValue("J".$i, $user->countRecord);
			$page->setCellValue("K".$i, $user->countActiveRecord);

			$i++;
		}
		

		$page->setTitle("Reports"); // Ставим заголовок "Test" на странице

		/* Начинаем готовиться к записи информации в xlsx-файл */
		$file = "files/system/reports/users.xlsx";
		$objWriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
		$objWriter->save($file);

		$response = Yii::$app->response;
		$response->sendFile($file)->send();
    }


    

}
