<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FOkrug */
/* @var $form ActiveForm */
?>
<div class="geo-_formCity">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'sort') ?>
    
        <div class="form-group">
            <button>Сохранить</buttton>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- geo-_formOkrug -->
