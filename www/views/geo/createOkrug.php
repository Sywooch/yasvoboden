<?php
	use yii\helpers\Url;
?>

<h1 class="title">Добавление Округа</h1>
<br>
<a href="<?=Url::toRoute(['/geo/index'])?>">Вернуться назад</a>
<br><br>
<div>
	<?=$this->render('_formOkrug', ['model' => $model]);?>
</div>