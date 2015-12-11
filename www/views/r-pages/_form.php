<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\RPages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rpages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'page_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]);?>


    <div class="form-group">
       <button>Сохранить</button>
    </div>

    <?php ActiveForm::end(); ?> 

</div>
