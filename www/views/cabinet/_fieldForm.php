<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FFields */
/* @var $form ActiveForm */
?>
<div class="cabinet-_fieldForm">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'type')->dropDownList($model->typeList)?>
        <?= $form->field($model, 'unit') ?>
        <?= $form->field($model, 'sort') ?>
    
        <div class="form-group">
            <button>Сохранить</button>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- cabinet-_fieldForm -->
