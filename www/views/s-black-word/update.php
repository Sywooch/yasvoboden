<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SBlackWord */

$this->title = 'Изменение слова';
$this->params['breadcrumbs'][] = ['label' => 'Sblack Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sblack-word-update">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
