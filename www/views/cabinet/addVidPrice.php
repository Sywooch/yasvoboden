<?php
	use yii\helpers\Url;
?>
<a href="<?=Url::toRoute(['/cabinet/item', 'id' => $id_category])?>">Вернуться назад</a>
<br><br>
<h1 class="title">Добавление вида цен</h1>

<?=$this->render('_vidPriceForm', ['model' => $SUnit]);?>
<br>