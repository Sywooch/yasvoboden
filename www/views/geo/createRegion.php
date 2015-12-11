<?php
	use yii\helpers\Url;
?>

<h1 class="title">Добавление Региона</h1>
<br>
<a href="<?=Url::toRoute(['/geo/index-region', "id" => $model->id_okrug])?>">Вернуться назад</a>
<br><br>
<div>
	<?=$this->render('_formRegion', ['model' => $model]);?>
</div>