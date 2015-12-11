<?php

namespace app\controllers;

use Yii;
use app\models\FCategory;
use app\models\RRelated;
use app\models\CategoryForm;
use yii\web\UploadedFile;
use app\models\FFields;
use app\models\SSelect;
use app\models\FPriceCategory;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\SUnit;
use app\models\RBadRecord;
use app\models\DefaultPage;
use app\models\RSettings;

class CabinetController extends AdminController
{

    public function actionIndex()
    {
        $get = Yii::$app->request->get();

        $id = 0;
        $r_cat = false;
        $params = "";

        if (isset($get["id"]) and ($get["id"] != 0))
        {
        	$id = $get["id"];
        	$r_cat = FCategory::findOne($id);
        	$brandChumbs = $r_cat->brandChumbs;  

    		if (count($brandChumbs) > 0)
               	foreach ($brandChumbs as $val) 
               		$params['breadcrumbs'][] = ['label' => $val["name"], 'url' => ['cabinet/index', "id" => $val["id"]]]; 

            $params['breadcrumbs'][] = ['label' => $r_cat->name, 'url' => ['cabinet/index', "id" => $id]];
        }

        $FCategory = FCategory::find()->where(['parent_id' => $id])->orderBy('sort, name')->all();
        
        return $this->render('index', ['category' => $FCategory, 'r_cat' => $r_cat, "params" => $params, "id" => $id]);
    }


    public function actionDelCategory()
    {
    	$post = Yii::$app->request->post();

        $id_element = $post["id_element"];

        $category = FCategory::findOne($id_element);
        $parent_id = $category->parent_id;
        $category->delete();

        $this->redirect(['/cabinet/index', 'id' => $parent_id]); 
    }

    public function actionDelField()
    {
        $post = Yii::$app->request->post();

        $id_element = $post["id_element"];

        $field = FFields::findOne($id_element);
        $parent_id = $field->id_category;
        $field->delete();

        $this->redirect(['/cabinet/item', 'id' => $parent_id]); 
    }

    public function actionAddCategory()
    {
    	$model = new CategoryForm();

    	$get = Yii::$app->request->get();
    	$id = 0;

    	if (isset($get["id"]))
    	{
    		$id = $get["id"];
    	}

    	$model->parent_id = $id;

    	if (Yii::$app->request->isPost) 
    	{
    		 $post = Yii::$app->request->post();

    		 $model->load($post);
    		 $model->image = UploadedFile::getInstance($model, 'image');

    		 if ($model->validate())
    		 {
    		 	$model->save();
    		 	$this->redirect(['cabinet/index', 'id' => $id]);
    		 }
    	}

    	return $this->render('createCategory', ['model' => $model, 'id' => $id]);
    }

    public function actionEditCategory()
    {
    	$get = Yii::$app->request->get();
    	$model = new CategoryForm();

    	if (isset($get["id"]))
    	{
    		$id = $get["id"];

    		$model->loadCategory($id);

    		if (Yii::$app->request->isPost)
	    	{
	    		$post = Yii::$app->request->post();

	    		$model->load($post);
	    		$model->image = UploadedFile::getInstance($model, 'image');
                $model->image_detail = UploadedFile::getInstance($model, 'image_detail');

	    		if ($model->validate())
	    		{
	    		 	$model->save();
	    			$this->redirect(['cabinet/index', 'id' => $model->parent_id]);
	    		}
	    	}


    		return $this->render('editCategory', ['model' => $model, 'id' => $model->parent_id]);
    	}
    }



    public function actionModalCategory()
    {
    	$FCategory = FCategory::find()->where(['parent_id' => 0])->all();
        $get = Yii::$app->request->get();
        $id = $get["id"];
        $cat = FCategory::findOne($id);

    	return $this->renderPartial('modalCategory', ['category' => $FCategory, 'r_cat' => $cat]);
    }

    public function actionModalCategoryRelated()
    {
        $FCategory = FCategory::find()->where(['parent_id' => 0])->all();
        $get = Yii::$app->request->get();
        $id = $get["id"];
        $cat = FCategory::findOne($id);

        return $this->renderPartial('modalCategoryRelated', ['category' => $FCategory, 'r_cat' => $cat]);
    }

    public function actionModalCategoryDefault()
    {
        $FCategory = FCategory::find()->where(['parent_id' => 0])->all();
        
        return $this->renderPartial('modalCategoryDefault', ['category' => $FCategory]);
    }

    public function actionModalPodCategory()
    {
        $post = Yii::$app->request->post();

        $id = $post["id_category"];
        $query = FCategory::find()->where(['parent_id' => $id]);
        $FCategory = $query->all();
        $get = Yii::$app->request->get();
        $cat = FCategory::findOne($get["id"]);

        if ($query->count() == 0)
            return "no";
        else
            return $this->renderPartial('modalPodCategory', ['category' => $FCategory, 'r_cat' => $cat]);
    }

    public function actionModalPodCategoryRelated()
    {
        $post = Yii::$app->request->post();

        $id = $post["id_category"];
        $query = FCategory::find()->where(['parent_id' => $id]);
        $FCategory = $query->all();
        $get = Yii::$app->request->get();
        $cat = FCategory::findOne($get["id"]);

        if ($query->count() == 0)
            return "no";
        else
            return $this->renderPartial('modalPodCategoryRelated', ['category' => $FCategory, 'r_cat' => $cat]);
    }

    public function actionModalPodCategoryDefault()
    {
        $post = Yii::$app->request->post();

        $id = $post["id_category"];
        $query = FCategory::find()->where(['parent_id' => $id]);
        $FCategory = $query->all();

        if ($query->count() == 0)
            return "no";
        else
            return $this->renderPartial('modalPodCategoryDefault', ['category' => $FCategory]);
    }

    public function actionAddCategoryDefault()
    {
        $post = Yii::$app->request->post();

        if (isset($post["category"]) and ($post["category"] != 0))
        {
            $id_category = $post["category"];
            $RSettings = RSettings::findOne(['type' => 'category', 'value' => $id_category]);
            $count = RSettings::find()->where(['type' => 'category'])->count();

            if ((!$RSettings) and ($count < 6))
            {
                $cat = new RSettings();
                $cat->type = 'category';
                $cat->value = $id_category;
                $cat->save();
            }
        }

        $this->redirect(['cabinet/default']);
    }

    public function actionAddRelCategory()
    {
        $get = Yii::$app->request->get();

        $id = $get["id"];
        $id_rel_category = $get["id_rel_category"];

        $RRelated = new RRelated();
        $RRelated->id_category = $id;
        $RRelated->id_related_category = $id_rel_category;

        $RRelated->save();
    }

    public function actionDeleteRelatedCategory()
    {
        $get = Yii::$app->request->get();

        $id = $get["id"];
        $id_rel_category = $get["id_rel_category"];

        $RRelated = RRelated::findOne(["id_category" => $id, "id_related_category" => $id_rel_category]);

        if ($RRelated)
            $RRelated->delete();
    }

    public function actionItem()
    {
        $get = Yii::$app->request->get();
        $id = $get["id"];

        $cat = FCategory::findOne($id);
        $option = FPriceCategory::findOne(["id_category" => $id]);
        if (!$option)
        {
            $option = new FPriceCategory();
            $option->id_category = $id;
            $option->save();
        }

        if (Yii::$app->request->isPost) 
        {
             $post = Yii::$app->request->post();

             $option->load($post);

             if ($option->validate())
             {
                $option->save();
             }
        }

        return $this->render('item', ['r_cat' => $cat, 'option' => $option]);
    }

    public function actionAddField()
    {
        $get = Yii::$app->request->get();
        $id = $get["id"];

        $field = new FFields();
        $field->id_category = $id;

        if (Yii::$app->request->isPost) 
        {
            $post = Yii::$app->request->post();

            $field->load($post);

            if ($field->validate())
            {
                $field->save();
                $this->redirect(['cabinet/item', 'id' => $id]);
            }
        }



        return $this->render('addField', ["field" => $field, "id_category" => $id]);
    }

    public function actionEditField()
    {
        $get = Yii::$app->request->get();
        $id = $get["id"];

        $field = FFields::findOne($id);

        if (Yii::$app->request->isPost) 
        {
            $post = Yii::$app->request->post();

            $field->load($post);

            if ($field->validate())
            {
                $field->save();
                $this->redirect(['cabinet/item', 'id' => $field->id_category]);
            }
        }

        return $this->render('editField', ["field" => $field, "id_category" => $field->id_category]);
    }

    public function actionField()
    {
        $get = Yii::$app->request->get();
        $id = $get["id"];

        $field = FFields::findOne($id);

        return $this->render('field', ['field' => $field]);
    }

    public function actionAddSelect()
    {
        $get = Yii::$app->request->get();
        $id = $get["id"];

        $select = new SSelect();
        $select->id_field = $id;

        if (Yii::$app->request->isPost) 
        {
            $post = Yii::$app->request->post();

            $select->load($post);

            if ($select->validate())
            {
                $select->save();
                $this->redirect(['cabinet/field', 'id' => $id]);
            }
        }

        return $this->render('addSelect', ["select" => $select, "id_field" => $id]);
    }

    public function actionEditSelect()
    {
        $get = Yii::$app->request->get();
        $id = $get["id"];

        $select = SSelect::findOne($id);
        

        if (Yii::$app->request->isPost) 
        {
            $post = Yii::$app->request->post();

            $select->load($post);

            if ($select->validate())
            {
                $select->save();
                $this->redirect(['cabinet/field', 'id' => $select->id]);
            }
        }

        return $this->render('editSelect', ["select" => $select, "id_field" => $id]);
    }

    public function actionDelSelect()
    {
        $post = Yii::$app->request->post();

        $id_element = $post["id_element"];

        $select = SSelect::findOne($id_element);
        $parent_id = $select->id_field;
        $select->delete();

        $this->redirect(['/cabinet/field', 'id' => $parent_id]); 
    }

    public function actionEditFilter()
    {
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();

        $id_category = $get["id"];
        $id_field = $post["id_field"];

        $cat = FCategory::findOne($id_category);

        $cat->installFilter($id_field);
    }

    public function actionAddVidPrice()
    {
        $get = Yii::$app->request->get();
        $id = $get["id"];

        $SUnit = new SUnit();
        $SUnit->id_category = $id;

        if (Yii::$app->request->isPost) 
        {
            $post = Yii::$app->request->post();

            $SUnit->load($post);

            if ($SUnit->validate())
            {
                $SUnit->save();
                $this->redirect(['cabinet/item', 'id' => $id]);
            }
        }



        return $this->render('addVidPrice', ["SUnit" => $SUnit, "id_category" => $id]);
    }

    public function actionEditVidPrice()
    {
        $get = Yii::$app->request->get();
        $id = $get["id"];

        $SUnit = SUnit::findOne($id);

        if (Yii::$app->request->isPost) 
        {
            $post = Yii::$app->request->post();

            $SUnit->load($post);

            if ($SUnit->validate())
            {
                $SUnit->save();
                $this->redirect(['cabinet/item', 'id' => $SUnit->id_category]);
            }
        }



        return $this->render('editVidPrice', ["SUnit" => $SUnit, "id_category" => $SUnit->id_category]);
    }


    public function actionDelVidPrice()
    {
        $post = Yii::$app->request->post();

        $id_element = $post["id_element"];
        
        $SUnit = SUnit::findOne($id_element);
        $parent_id = $SUnit->id_category;
        $SUnit->delete();

        $this->redirect(['/cabinet/item', 'id' => $parent_id]); 
    }

    public function actionBadRecordIndex()
    {
        $RBadRecord = RBadRecord::find()->all();

        return $this->render('badRecordIndex', ['RBadRecord' => $RBadRecord]);
    }

    public function actionBadRecordItem($id)
    {
        $record = RBadRecord::findOne($id);

        return $this->render('badRecordItem', ['record' => $record]);
    }

    public function actionBadRecordReset($id)
    {
        $record = RBadRecord::findOne($id);
        $record->delete();

        $this->redirect(['cabinet/bad-record-index']);
    }

    public function actionBadRecordDelete($id)
    {
        $record = RBadRecord::findOne($id);
        $record->record->delete();

        $this->redirect(['cabinet/bad-record-index']);
    }

    /*Отчистка категорий
        public function actionDelTest()
        {
            $FCategory = FCategory::find()->all();

            $txt = "";
            foreach ($FCategory as  $cat) 
            {
                if ($cat->parent_id != 0)
                    if (!$cat->parent)
                    {
                        $txt .= $cat->id." ".$cat->name."<br>";
                        $cat->delete();
                    }
            }

            return $txt;
        }
    */

     public function actionDefault()
     {
     	$model = new DefaultPage();
     	$post = Yii::$app->request->post();

     	if (isset($post["addImageSlider"]))
     	{
     		$model->image_slider = UploadedFile::getInstance($model, 'image_slider');
     		$model->addImageSlider();
     	}

        if (isset($post['addPreText']))
        {
            $model->load($post);
            $model->addPreText();
            $model->preText = "";
        }

     	return $this->render('default', ['model' => $model]);
     }

     public function actionDelSetting($id)
     {
        $RSettings = RSettings::findOne($id);

        $RSettings->delete();

        $this->redirect(['cabinet/default']);
     }


} 
