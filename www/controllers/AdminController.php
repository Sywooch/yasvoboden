<?php

namespace app\controllers;

use Yii;
use app\models\FOkrug;;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * ReklamaController implements the CRUD actions for RReklama model.
 */
class AdminController extends CController
{
    public $layout = "admin_main"; 

    public function behaviors()
    {   
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if ((Yii::$app->user->identity->role != "777") and (Yii::$app->user->identity->role != "888"))
                            {
                                $this->redirect(['site/index']);
                                return false;
                            }
                            else
                                return true;

                        }
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
   
}
