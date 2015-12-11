<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RReklama */

$this->title = 'Создание рекламы';
$this->params['breadcrumbs'][] = ['label' => 'Rreklamas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rreklama-create">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
