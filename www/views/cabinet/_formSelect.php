<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SSelect */
/* @var $form ActiveForm */
?>
<div class="cabinet-_formSelect">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'value') ?>
        <div class="form-group">
             <button>Сохранить</button>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- cabinet-_formSelect -->
