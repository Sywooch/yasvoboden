<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Черный список слов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sblack-word-index">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'value',
 
           ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>

</div>
