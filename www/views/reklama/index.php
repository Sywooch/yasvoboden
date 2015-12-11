<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реклама';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rreklama-index">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Картинка',
                'format' => 'raw',
                'value' => function($data){
                    return Html::img($data->imageSrc,[
                        'style' => 'max-width:300px;'
                    ]);
                },
            ],
            'link',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>

</div>
