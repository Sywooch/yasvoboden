<?php
	use yii\helpers\Url;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Html; 
?>
<a href="<?=(isset($r_cat->parent))?$r_cat->parent->adminUrl:Url::toRoute(['/cabinet/bad-record-index'])?>">Вернуться назад</a>
<br><br>
<h1 class="title">Просмотр предложения<h1>
<br>
<h1 class="title">Нажали <?=$record->count?> раз<h1>
<h1 class="title">Нажали последний раз <?=$record->dateText?><h1>
<br>
<h1 class="title">Предложение<h1>
<table class="table">
	<tr>
		<td><b>Категория</b></td>
		<td><?=$record->record->catName?></td>
	</tr>
	<tr>
		<td><b>Название</b></td>
		<td><?=$record->record->name?></td>
	</tr>
	<tr>
		<td><b>Время</b></td>
		<td>
			<p><span><?=$record->record->timeBack["real_value"]?></span> <?=$record->record->timeBack["izmerenie"]?></p>
			<p>назад</p>
		</td>
	</tr>
	<tr>
		<td><b>Город</b></td>
		<td><?=$record->record->geo?></td>
	</tr>
	<tr>
		<td><b>Текст</b></td>
		<td><?=$record->record->description?></td>
	</tr>
	<tr>
		<td><b>Телефон</b></td>
		<td><?=$record->record->phone?></td>
	</tr>
</table>


<br><br>
<h1 class="title">Поля<h1>
<table class="table">
	<?foreach ($record->record->fields as $field):?>
		<tr>
			<td><?=$field->typeField->name;?></td>
			<td><?=$field->val;?> <?=$field->typeField->unit;?></td>
		</tr>
	<?endforeach;?>
</table>

<br><br>
<h1 class="title">Пользователь<h1>
<table class="table">
	<tr>
		<td>Логин</td>
		<td><?=$record->record->user->login?></td>
	</tr>
	<tr>
		<td>Фамилия Имя</td>
		<td><?=$record->record->user->surname?> <?=$record->record->user->name?></td>
	</tr>
	<tr>
		<td>Телефон</td>
		<td><?=$record->record->user->phone?></td>
	</tr>
	<tr>
		<td>email</td>
		<td><?=$record->record->user->email?></td>
	</tr>
</table>

<br><br>
<h1 class="title">Действия<h1>
<br>
<a href="<?=Url::toRoute(['cabinet/bad-record-reset', 'id' => $record->id])?>"><button>Все хорошо</button></a>
<a href="<?=Url::toRoute(['cabinet/bad-record-delete', 'id' => $record->id])?>"><button>Удалить</button></a>




