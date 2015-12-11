<?php

namespace app\controllers;

use Yii;
use app\models\RReklama;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;


/**
 * ReklamaController implements the CRUD actions for RReklama model.
 */
class ReklamaController extends AdminController
{
    /**
     * Lists all RReklama models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RReklama::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RReklama model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RReklama();

        
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

             $model->load($post);
             $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

             if ($model->validate())
             {
                $model->save();
                $this->redirect(['index']);
             }
        }
        
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing RReklama model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

             $model->load($post);
             $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

             if ($model->validate())
             {
                $model->save();
                $this->redirect(['index']);
             }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing RReklama model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /** 
     * Finds the RReklama model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RReklama the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RReklama::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
