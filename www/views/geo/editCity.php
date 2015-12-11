<?php
	use yii\helpers\Url;
?>

<h1 class="title">Редактирование Города</h1>
<br>
<a href="<?=Url::toRoute(['/geo/index-city', "id" => $model->id_region])?>">Вернуться назад</a>
<br><br>
<div>
	<?=$this->render('_formCity', ['model' => $model]);?>
</div>