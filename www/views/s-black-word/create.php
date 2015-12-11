<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SBlackWord */

$this->title = 'Добавление слова';
$this->params['breadcrumbs'][] = ['label' => 'Sblack Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sblack-word-create">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
