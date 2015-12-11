<?php
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;
	use yii\widgets\Breadcrumbs;
?>

<h1 class="title">Проверка предложений</h1>

<?if (count($RBadRecord) > 0):?>
	<table class="table">
		<tr>
			<td>ID</td>
			<td>Название</td>
			<td>Количество</td>
			<td>Последнее нажатие</td>
			<td>Логин</td>
			<td>Фамилия Имя</td>
			<td>Email</td>
			<td>Телефон пользователя</td>
			<td>Телефон предложения</td>
		</tr>
		<?foreach($RBadRecord as $rec):?>
			<tr>
				<td><?=$rec->id;?></td>
				<td><a href="<?=Url::toRoute(['cabinet/bad-record-item', 'id' => $rec->id])?>"><?=$rec->record->name;?></a></td>
				<td><?=$rec->count;?></td>
				<td><?=$rec->dateText;?></td>
				<td><?=$rec->record->user->login;?></td>
				<td><?=$rec->record->user->surname;?> <?=$rec->record->user->name;?></td>
				<td><?=$rec->record->user->email;?></td>
				<td><?=$rec->record->user->phone;?></td>
				<td><?=$rec->record->phone;?></td>
			</tr>
		<?endforeach;?>
	</table>
<?else:?>
	<p>Нет ни одного элемента!</p>
<?endif;?>

