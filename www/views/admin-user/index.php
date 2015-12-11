<?php
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;
	use yii\widgets\Breadcrumbs;
	use yii\helpers\Html;
?>
 
<h1 class="title">Пользователи</h1>

<div class="panelBlock">
	<h1 class="title">Фильтр</h1>
	<?php $form = ActiveForm::begin(['method' => 'get']); ?>
		<?= Html::activeHiddenInput($filterForm, 'id_city', ['id' => 'id_city_filter']) ?>
		<?= Html::activeHiddenInput($filterForm, 'id_region', ['id' => 'id_region_filter']) ?>
		<?= Html::activeHiddenInput($filterForm, 'id_okrug', ['id' => 'id_okrug_filter']) ?>
		<?= Html::activeHiddenInput($filterForm, 'id_cat', ['id' => 'id_cat_filter']) ?>
		<table class="table">
			<tr>
				<td>География: </td>
				<td><a href="<?=Url::toRoute('/admin-user/modal-geo');?>" class="popup-modal select-town" id="selCity"><?=$filterForm->geoName?></a></td>
			</tr>
			<tr>
				<td>Категория: </td>
				<td><a href="<?=Url::toRoute('/admin-user/modal-category');?>" class="btnParentCategory" id="selCat"><?=$filterForm->catName;?></a></td>
			</tr>
			<tr>
				<td>Поиск по полю <?= Html::activeDropDownList($filterForm, 'search_field', $search_field) ?></td>
				<td><?= Html::activeTextInput($filterForm, 'search')?></a></td>
			</tr>
			<tr>
				<td></td>
				<td><button type="submit">Применить</button></td>
			</tr>
		</table>
	<?php ActiveForm::end(); ?>
</div>

<?php $form = ActiveForm::begin(['method' => 'post']); ?>
	<div class="panelBlock">
		<h1 class="title">Операции</h1>
			<table class="table">
				<tr>
					<td><?= Html::activeTextInput($functionsForm, 'addSum') ?></td>
					<td><button type="submit" name="addBalans">Пополнить</button></td>
				</tr>
				<tr>
					<td></td>
					<td><button type="submit" name="saveReport">Сохранить в Excel</button></td>
				</tr>
			</table>
	</div>
	
	<table class="table">
		<tr>
			<td>
				<input type="checkbox" id="selectAll">
			</td>
			<td>
				<b><a href="<?=Url::toRoute(['/admin-user/index', 'sort' => 'r_users.id']);?>">ID</a></b>
			</td>
			<td>
				<b><a href="<?=Url::toRoute(['/admin-user/index', 'sort' => 'r_users.surname']);?>">Фамилия Имя</a></b>
			</td>
			<td>
				<b><a href="<?=Url::toRoute(['/admin-user/index', 'sort' => 'r_users.login']);?>">Логин</a></b>
			</td>
			<td>
				<b><a href="<?=Url::toRoute(['/admin-user/index', 'sort' => 'r_users.email']);?>">Email</a></b>
			</td>
			<td>
				<b>Телефон</b>
			</td>
			<td> 
				<b><a href="<?=Url::toRoute(['/admin-user/index', 'sort' => 'r_users.money']);?>">Баланс</a></b>
			</td>
			<td>
				<b><a href="<?=Url::toRoute(['/admin-user/index', 'sort' => 'f_okrug.name']);?>">Округ</a></b>
			</td>
			<td>
				<b><a href="<?=Url::toRoute(['/admin-user/index', 'sort' => 'f_region.name']);?>">Регион</a></b>
			</td>
			<td>
				<b><a href="<?=Url::toRoute(['/admin-user/index', 'sort' => 'f_city.name']);?>">Город</a></b>
			</td>
			<td>
				<b>Всего обьв-ий</b>
			</td>
			<td>
				<b>Активных обьв-ий</b>
			</td>
		</tr>
		<?foreach ($users as $user):?>
			<tr>
				<td>
					<?= Html::activeCheckbox($functionsForm, 'id_user[]', ['class' => 'check', 'label' => false, 'value' => $user->id]) ?>
				</td>
				<td>
					<?=$user->id;?>
				</td>
				<td>
					<?=$user->surname;?> <?=$user->name;?>
				</td>
				<td>
					<?=$user->login;?>
				</td>
				<td>
					<?=$user->email;?>
				</td>
				<td>
					<?=$user->phone;?>
				</td>
				<td>
					<?=$user->money;?>
				</td>
				<td>
					<?=$user->city->region->okrug->name;?>
				</td>
				<td>
					<?=$user->city->region->name;?>
				</td>
				<td>
					<?=$user->city->name;?>
				</td>
				<td>
					<?=$user->countRecord;?>
				</td>
				<td>
					<?=$user->countActiveRecord;?>
				</td>
			</tr>
			</tr>
		<?endforeach?>
	</table>
<?php ActiveForm::end(); ?>

 	