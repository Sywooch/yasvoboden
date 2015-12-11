<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RPages */

$this->title = 'Update Rpages: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Rpages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rpages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
