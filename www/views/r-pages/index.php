<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rpages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'page_name',
            'title',
            'text:ntext',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>

</div>
