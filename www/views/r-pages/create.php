<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RPages */

$this->title = 'Create Rpages';
$this->params['breadcrumbs'][] = ['label' => 'Rpages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rpages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
