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
use app\models\User;
use app\models\FRegion;
use app\models\FCity;
use app\models\FOkrug;
use app\models\Feedback;
use app\models\MEmailConfirm;
use app\models\RItemsForm;
use yii\web\UploadedFile;
use app\models\RTableUnitpay;
use app\models\RActivateWeeksItem;

class UserController extends CController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => "",
                'denyCallback' => function ($rule, $action) {
                                    $this->redirect(['site/index', "auth" => "on"]);
                                },
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['register', 'register-finish', 'activate-user-email', 'disabled-user-email'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $this->redirect(['site/index']);
                        }
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['register', 'modal-city', 'modal-regions', 'modal-cityes', 
                                        'activate-user-email', 'disabled-user-email', 'register-finish'], 
                        'roles' => ['?'],
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
        $user = Yii::$app->user->identity;

        $query = RItems::find()->where(['id_user' => $user->id]);
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);

        $items = $query->offset($pages->offset)->limit($pages->limit)->all();

        $errorMsg = false;
        $session = Yii::$app->session;
        if ($session->hasFlash('error'))
            $errorMsg = $session->getFlash('error');

        $successMsg = false;
        if ($session->hasFlash('success'))
            $successMsg = $session->getFlash('success');

        $Feedback = new Feedback();

        return $this->render('index', ['user' => $user, 'items' => $items, 'pages' => $pages, 'errorMsg' => $errorMsg, 'Feedback' => $Feedback,
                            'successMsg' => $successMsg]);
    }

    public function actionEditUser()
    {
        $user = Yii::$app->user->identity;
        $user_pass = User::findOne($user->id);

        $user->scenario = 'edit-user';
        $user_pass->scenario = 'edit-password';
        $user_pass->password = "";

        $session = Yii::$app->session;
        $post = Yii::$app->request->post();
        $msg = false;

        
        if(isset($post['editUser']))
        {
            // Безопасное присваивание значений атрибутам
            $user->attributes = $post['User'];
            
            if ($user->validate())
            {
                $user->save(false);
                $session->setFlash('successEditUser',"Учетные данные успешно сохранены!");
            }
        }

        if(isset($post['editPassword']))
        {
            $user_pass->attributes = $post['User'];

            if ($user_pass->validate())
            {
                $user_pass->save(false);
                $session->setFlash('successEditUser',"Пароль успешно изменен!");
            }

        }


        if($session->hasFlash('successEditUser'))
        {
            $msg = $session->getFlash('successEditUser'); 
        }

        $user_pass->password = "";
        $user_pass->password_repeat = "";

        return $this->render('editUser', ['user' => $user, 'user_pass' => $user_pass, 'msg' => $msg]);
    }

    public function actionRegister()
    {
        $user = new User();
        $user->scenario = 'register';

        $post = Yii::$app->request->post();
        if(isset($post['User']))
        {
            // Безопасное присваивание значений атрибутам
            $user->attributes = $post['User'];
            
            if ($user->validate())
            {
                $user->save(false);
                $user->setEmailConfirm(); 
                $this->redirect(['/user/register-finish']);
            }
            else
            {
                $user->password = "";
                $user->password_repeat = "";
            }
        }

        return $this->render('register', ['user' => $user]);
    }

    public function actionModalCity()
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

        return $this->renderPartial('modal', ['okrugs' => $okrugs, 'regions' => $regions, 'cityes' => $cityes]);
    }

    public function actionModalCityNewRecord()
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

        return $this->renderPartial('modalCityRecord', ['okrugs' => $okrugs, 'regions' => $regions, 'cityes' => $cityes]);
    }

    public function actionRegions()
    {
        $session = Yii::$app->session;

        if (isset($_REQUEST["id_okrug"]))
            $id_okrug = $_REQUEST["id_okrug"];
        else
            $id_okrug = 0;

        $regions = FRegion::find()->where(['id_okrug' => $id_okrug])->all();
        return $this->renderPartial('@app/views/c/regions.php', ['regions' => $regions]);
    }

    public function actionCityes()
    {
        $session = Yii::$app->session;

        if (isset($_REQUEST["id_region"]))
            $id_region = $_REQUEST["id_region"];
        else
            $id_region = 0;

        $cityes = FCity::find()->where(['id_region' => $id_region])->all();
        return $this->renderPartial('@app/views/c/cityes.php', ['cityes' => $cityes]);
    }

    public function actionActivateUserEmail()
    {
        $get = Yii::$app->request->get();
        $session = Yii::$app->session;

        if (isset($get["token"]))
        {
            $token = $get["token"];

            $m_email_confirm = MEmailConfirm::findOne(['token' => $token]);

            if ($m_email_confirm)
            {
                $m_email_confirm->activate();
                $session->setFlash('success',"Активация пользователя прошла успешна!");
            }
            else
               $session->setFlash('error',"Ошибка активации");
        }
        else
            $session->setFlash('error',"Ошибка активации");

        if($session->hasFlash('success'))
        {
            $class = 'success';
            $msg = $session->getFlash('success'); 
        }
        elseif ($session->hasFlash('error'))
        {
            $class = 'error';
            $msg = $session->getFlash('error'); 
        }
        else
        {
            $class = 'error';
            $msg = "Ошибка не определена! Пожалуйста обратитесь к администратору!";  
        }

        return $this->render('endActivate', ['msg' => $msg, 'class' => $class]);
    }

    public function actionDisabledUserEmail()
    {
        $get = Yii::$app->request->get();
        $session = Yii::$app->session;

        if (isset($get["token"]))
        {
            $token = $get["token"];

            $m_email_confirm = MEmailConfirm::findOne(['token' => $token]);

            if ($m_email_confirm)
            {
                $m_email_confirm->disabled();
                $session->setFlash('success',"Спасибо! Извините за доствленное неудобство!");
            }
            else
               $session->setFlash('error',"Ошибка активации");

        }
        else
            $session->setFlash('error',"Ошибка активации");

        if($session->hasFlash('success'))
        {
            $class = 'success';
            $msg = $session->getFlash('success'); 
        }
        elseif ($session->hasFlash('error'))
        {
            $class = 'error';
            $msg = $session->getFlash('error'); 
        }
        else
        {
            $class = 'error';
            $msg = "Ошибка не определена! Пожалуйста обратитесь к администратору!";  
        }

        return $this->render('endActivate', ['msg' => $msg, 'class' => $class]);
    }


    public function actionDelRecord()
    {
        $post = Yii::$app->request->post();

        $id_element = $post["id_element"];

        $item = RItems::findOne($id_element);

        $item->delete();

        $this->redirect(['/user/index']); 

    }

    public function actionRegisterFinish()
    {
        return $this->render('register-finish');
    }

    public function actionActivateRecord()
    {
        $get = Yii::$app->request->get();

        $id_item = $get["id"];

        $item = RItems::findOne($id_item);

        if ($item->isStatus)
            $item->disabled();
        else
            $item->enabled();

        $this->redirect(['/user/index']);
    }

    public function actionAddMoney()
    {
        $post = Yii::$app->request->post();
        
        if ($post["sum"] > 0)
        {
            $user = Yii::$app->user->identity;
           
            $sum = $post["sum"];

           
            $secret_key = "33e897e49a461ef91e5b800de91aa720";
            $user_id = $user->id;
            $sign = md5($user_id."RUB"."Пополнение баланса".$sum.$secret_key);
            $url = "https://unitpay.ru/pay/24248-f6034?sum=$sum&account=$user_id&currency=RUB&desc=Пополнение+баланса&sign=$sign";

            $this->redirect($url);
        }
        else
            $this->redirect(['user/index']);
    }

    public function actionFeedback()
    {
        $post = Yii::$app->request->post();

        $Feedback = new Feedback();

        $Feedback->load($post);
        $user = Yii::$app->user->identity;
        $session = Yii::$app->session;

        if ($Feedback->validate())
        {
            $Feedback->send($user->id);
            $session->setFlash('success',"Ваше сообщение отправлено!");

            $this->redirect(['user/index']);
        }
        else
        {
            $session->setFlash('error',"Ваше сообщение не отправлено! Произошла ошибка!");
        }
    }

    public function actionModalHistory()
    {
        $user = Yii::$app->user->identity;


        return $this->renderPartial('modalHistory', ['user' => $user]);
    }

    public function actionModalCategory()
    {
        $FCategory = FCategory::find()->where(['parent_id' => 0])->orderBy('name')->all();

        return $this->renderPartial('modalCategory', ['categoryes' => $FCategory]);
    }

    public function actionPodCategory()
    {
        $post = Yii::$app->request->post();
        $FCategory = FCategory::find()->where(['parent_id' => $post["id_category"]])->orderBy('name')->all();

        $cat = FCategory::findOne($post["id_category"]);

        if (count($FCategory) > 0)
            return $this->renderPartial('modalPodCategory', ['categoryes' => $FCategory, 'cat' => $cat]);
        else
            return "no";
    }

    public function actionAddRecord()
    {
        
        $get = Yii::$app->request->get();

        if (isset($get["id_category"]))
        {
            $id_category = $get["id_category"];

            $cat = FCategory::findOne($id_category);

            if ((!$cat) or ($cat->bool_item != 1))
                $this->redirect(['site/index']);
        }


        $user = Yii::$app->user->identity;
        $model = new RItemsForm();
        $model->id_category = $id_category;

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $model->load($post);
            $model->image = UploadedFile::getInstances($model, 'image');
           
            if ($model->validate())
            {
                $model->save();
                $this->redirect(['user/index']);
            }
            
        }
        
        
        return $this->render('createRecord', ['user' => $user, 'model' => $model, 'cat' => $cat]);
    }

    public function actionEditRecord($id)
    {
        $RItems = RItems::findOne($id);

        $model = new RItemsForm();

        $model->loadForm($RItems);
        $user = Yii::$app->user->identity;
        $cat = FCategory::findOne($model->id_category);

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $model->load($post);
            $model->image = UploadedFile::getInstances($model, 'image');
           
            if ($model->validate())
            {
                $model->save();
                $this->redirect(['user/index']);
            }
            
        }


        return $this->render('editRecord', ['user' => $user, 'model' => $model, 'cat' => $cat]);        
    }

    public function actionDeleteImage()
    {
        $post = Yii::$app->request->post();

        $id = $post["id"];

        $RImages = RImages::findOne($id);

        if ($RImages->delete())
            return "true";
        else
            return "false";
    }

    public function actionSendSms($id)
    {
        $RItems = RItems::findOne($id);
        $session = Yii::$app->session;

        if ($RItems)
        {
            $r = $RItems->sendSms();

            if ($r)
            {
                if (($r != "100") and ($r != 200))
                    $session->setFlash('success', "На Ваш номер отправлено СМС сообщение с номером предложения!");
                elseif ($r == 100)
                    $session->setFlash('error', "Не удалось отправить СМС. Непредвиденная ошибка!");
                elseif ($r == 200)
                    $session->setFlash('error', "Не удалось отправить СМС. Неверный формат телефона!");
            }
            else
                $session->setFlash('error', "Вам уже было отправлено СМС с данным номером предложения!");
        }
        else
            $session->setFlash('error', "Данного предложения не существует!");

        $this->redirect(['user/index']);
    }

    public function actionModalPlan($id)
    {
        $item = RItems::findOne($id);

        $post = Yii::$app->request->post();

        $RActivateWeeksItem = RActivateWeeksItem::find()->where(['id_item' => $id])->all();
        $weeks = "";
        foreach ($RActivateWeeksItem as $week) 
        {
            $weeks[$week->week] = true;
        }

        if (isset($post["save"]))
        {
            $RActivateWeeksItem = RActivateWeeksItem::deleteAll(['id_item' => $id]);
            foreach ($post["week"] as $week) 
            {
                $model = new RActivateWeeksItem();
                $model->id_item = $id;
                $model->week = $week;
                $model->time = $post["time"];
                $model->status = 1;
                $model->save();
            }

            $this->redirect(['user/index']);
        }

        return $this->renderPartial('modalPlan', ['item' => $item, 'weeks' => $weeks]);
    }


    
}
