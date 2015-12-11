<?php
	use yii\helpers\Url;
?>
<a href="<?=Url::toRoute(['/cabinet/field', 'id' => $id_field])?>">Вернуться назад</a>
<br><br>
<h1 class="title">Добавление значения</h1>

<?=$this->render('_formSelect', ['model' => $select]);?>
<br>