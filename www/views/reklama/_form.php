<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RReklama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rreklama-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <?if ($model->imageSrc):?>
    	<img src="<?=$model->imageSrc?>" style="max-width: 300px;">
    <?endif;?>

    <?= $form->field($model, 'link')->textInput() ?>

    <div class="form-group">
        <button>Сохранить</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
