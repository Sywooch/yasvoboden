<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SBlackWord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sblack-word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <button>Сохранить</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
