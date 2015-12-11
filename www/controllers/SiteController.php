<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RImages;
use app\models\FCategory;
use app\models\RItems;
use yii\data\Pagination;
use app\models\RFields;
use app\models\RReklama;
use app\models\SearchForm;
use app\models\RForgout;
use app\models\RPages;
use app\models\RBadRecord;
use app\models\RActivateWeeksItem;

class SiteController extends CController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions() 
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $get = Yii::$app->request->get();
        $parent_cat = false;
        
        $params = "";

        if (isset($get["cat"]))
        {
            $cat_id = $get["cat"];
            $parent_cat = FCategory::findOne($cat_id);

            $brandChumbs = $parent_cat->brandChumbs;

            $cat_name = $parent_cat->name;

            if (count($brandChumbs) > 0)
                foreach ($brandChumbs as $val) 
                    $params['breadcrumbs'][] = ['label' => $val["name"], 'url' => [$val["url"], "cat" => $val["id"]]]; 
            
        }
        else
            $cat_id = 0;

        $FCategory = FCategory::find()->where(['parent_id' => $cat_id])->orderBy('sort, name')->all();

        $RReklama = RReklama::find()->all();

        return $this->render('index', ['category' => $FCategory, 'parent_cat' => $parent_cat, 'params' => $params, 'reklama' => $RReklama]);
    }

    public function actionItems()
    {
        $get = Yii::$app->request->get();
        $parent_cat = false;
        
        $params = "";

        if (isset($get["cat"]))
        {
            $cat_id = $get["cat"];
            $parent_cat = FCategory::findOne($cat_id);

            $brandChumbs = $parent_cat->brandChumbs;

            $cat_name = $parent_cat->name;

            if (count($brandChumbs) > 0)
                foreach ($brandChumbs as $val) 
                    $params['breadcrumbs'][] = ['label' => $val["name"], 'url' => [$val["url"], "cat" => $val["id"]]]; 
            
        }
        else
            $cat_id = 0;

        $get = Yii::$app->request->get();
        $session = Yii::$app->session;

        $field_value = "";
        if (isset($get["id_field"]))
        {
            $id_field = $get["id_field"];
            $value = $get["value"];
            $field_value[$id_field] = $value;
            $query = RItems::find()->joinWith('fields')->where(['r_fields.id_field' => $id_field, 'r_fields.value' => $value]);
        }
        else
            $query = RItems::find()->where(['id_parent' => $cat_id]);

        $query = $query->isActive();

        if (isset($session["GEO"]))
            $query = $query->city($this->geo);
    
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);

        $items = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('items', ['parent_cat' => $parent_cat, 'params' => $params, 'items' => $items, 'pages' => $pages, 
            'field_value' => $field_value]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome(); 
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionGetPhone()
    {
        $id_item = $_REQUEST["id"];

        $item = RItems::findOne($id_item);

        $res["status"] = "ok";
        $res["result"] = "<b style='font-size: 13px; font-weight: bold;'>".$item->phone."</b>";

        return json_encode($res);
    }

    public function actionSearch() 
    {
        $query = RItems::find();
        $get = Yii::$app->request->get();

        $searchForm = new SearchForm();
        $searchForm->load($get);
        $query = $searchForm->setQuery($query);
        
        $query = $query->isActive();

        if (isset($session["GEO"]))
            $query = $query->city($this->geo);
    
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);

        $items = $query->offset($pages->offset)->limit($pages->limit)->all();

        
        return $this->render('search', ['items' => $items, 'pages' => $pages, 'searchForm' => $searchForm]);
    }

    public function actionForgout()
    {
        $get = Yii::$app->request->get();
        $id_user = $get["id_user"];
        $login = $get["login"];
        $token = $get["token"];

        $RForgout = RForgout::findOne(['id_user' => $id_user, 'token' => $token]);

        if ($RForgout)
            if ($RForgout->validGet($login))
                $this->redirect(['user/edit-user']);
            else
                $this->redirect(['site/index']);
        else
            $this->redirect(['site/index']);

    }

    public function actionPage($name)
    {
        
        $RPages = RPages::findOne(["page_name" => $name]);

        return $this->render("page", ["page" => $RPages]);
    }

    public function actionTarif()
    {
        $FCategory = FCategory::find()->where(["bool_item" => 1])->all();

        $RPages = RPages::findOne(["page_name" => 'tarif']);

        return $this->render('tarif', ["categories" => $FCategory, 'page' => $RPages]);
    }

    public function actionBadRecord()
    {
        $post = Yii::$app->request->post();

        $id = $post["id"];

        $RBadRecord = RBadRecord::findOne(["id_item" => $id]);

        if (!$RBadRecord)
        {
            $RBadRecord = new RBadRecord();
            $RBadRecord->id_item = $id;
            $RBadRecord->date = time();
            $RBadRecord->count = 0;
            $RBadRecord->save();
        }
        

        $RBadRecord->addRecord();
    }

    public function actionDefault()
    {
    	return $this->render('default');
    }

    public function actionTest()
    {
        $time = time();

        $week_now = date("w", $time);
        $RActivateWeeksItem = RActivateWeeksItem::find()->where(['status' => 1]);
        $RActivateWeeksItem = $RActivateWeeksItem->andWhere(['>=', 'time', "12:00"])->all();

        print_r($RActivateWeeksItem);        
    }
}
