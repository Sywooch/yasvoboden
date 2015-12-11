<?php
	use yii\helpers\Url;
?>

<h1 class="title">Добавление категории</h1>
<br>
<a href="<?=Url::toRoute(['/cabinet/index', 'id' => $id])?>">Вернуться назад</a>
<br><br>
<div>
	<?=$this->render('_formCategory', ['model' => $model]);?>
</div>