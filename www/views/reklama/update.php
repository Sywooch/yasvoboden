<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RReklama */

$this->title = 'Изменение рекламы: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rreklamas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rreklama-update">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
