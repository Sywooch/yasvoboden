<?php
	use yii\helpers\Url;
?>
<a href="<?=Url::toRoute(['/cabinet/item', 'id' => $id_category])?>">Вернуться назад</a>
<br><br>
<h1 class="title">Добавление поля</h1>

<?=$this->render('_fieldForm', ['model' => $field]);?>
<br>