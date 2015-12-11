<?php
	use yii\helpers\Url;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Html; 
?>
<a href="<?=(isset($r_cat->parent))?$r_cat->parent->adminUrl:Url::toRoute(['/cabinet/index'])?>">Вернуться назад</a>
<br><br>
<h1 class="title">Категория "<?=$r_cat->name;?>"<h1>
<br>
<h1 class="title">Поля<h1>
<a href="<?=Url::toRoute(['/cabinet/add-field', 'id' => $r_cat->id])?>">Добавить</a>
<table class="table">
	<tr>
		<td><b>Название</b></td>
		<td><b>Тип</b></td>
		<td><b>Единица измерения</b></td> 
		<td><b>Действия</b></td>
	</tr>
	<?if ($r_cat->fields):?>
		<?foreach ($r_cat->fields as $field):?>
			<tr>
				<td><a href="<?=$field->adminUrl?>"><?=$field->name;?></a></td>
				<td><?=$field->typeLink->rus_name;?></td>
				<td><?=$field->unit;?></td>
				<td>
					<a href="<?=Url::toRoute(['/cabinet/edit-field', 'id' => $field->id])?>" class="info-edit-btn">редактировать</a><br>
					<a href="#delConfirm" class="del_rec info-del-btn" data-id="<?=$field->id;?>">удалить</a>
				</td>
			</tr>
		<?endforeach;?>
	<?endif;?>
</table>

<div id="delConfirm" class="white-popup-block mfp-hide">
	<div class="towns-modal-inner">
		<a href="#" class="mfp-close"></a>
		<div class="confirm">
			Вы действительно хотите удалить данный элемент?
		</div>
		<div class="btnBlock">
			<button id="btnYesField">Да</button>
			<button id="btnNo">Нет</button>
		</div>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form-delete-field', 'action' => Url::toRoute('/cabinet/del-field')]);?>
	<input type="hidden" name="id_element" id="id_element"> 
<?php ActiveForm::end(); ?>

<br><br>
<h1 class="title">Фильтр<h1>
<?php $form = ActiveForm::begin(['id' => 'form-edit-filter']);?>
	<ul>
		<li><input type="radio" class="b_filter" value="0" name="b_filter" <?if (!$r_cat->activeFilter):?>checked<?endif;?>>Нет</li>
		<?foreach ($r_cat->selectFields as $field):?>
			<li>
				<input type="radio" class="b_filter" name="b_filter" value="<?=$field->id;?>" <?if ($r_cat->activeFilter == $field->id):?>checked<?endif;?>>
				<?=$field->name;?>
			</li> 
		<?endforeach;?>
	</ul>
	<input id="urlEditFilter" type="hidden" value="<?=Url::toRoute(['/cabinet/edit-filter', 'id' => $r_cat->id])?>">
<?php ActiveForm::end(); ?>

<br><br>
<h1 class="title">Опции<h1>

<?php $form = ActiveForm::begin(['id' => 'form-edit-option']);?>
	<table class="table">
		<tr>
			<td>Цена</td>
			<td><?=Html::activeTextInput($option, 'price');?></td>
		</tr>
		<tr>
			<td>Время</td>
			<td><?=Html::activeTextInput($option, 'timeText');?></td>
		</tr>
	</table>
	<button>Сохранить</button>
<?php ActiveForm::end(); ?>
<br><br>
<h1 class="title">Виды цен<h1>
<a href="<?=Url::toRoute(['/cabinet/add-vid-price', 'id' => $r_cat->id])?>">Добавить</a>
<table class="table">
	<tr>
		<td><b>Значение</b></td>
	</tr>
	<?if ($r_cat->typesPrice):?>
		<?foreach ($r_cat->typesPrice as $price):?>
			<tr>
				<td><?=$price->name;?></td>
				<td>
					<a href="<?=Url::toRoute(['/cabinet/edit-vid-price', 'id' => $price->id])?>" class="info-edit-btn">редактировать</a><br>
					<a href="#delConfirmPrice" class="del_rec info-del-btn" data-id="<?=$price->id;?>">удалить</a>
				</td>
			</tr>
		<?endforeach;?>
	<?endif;?>
</table>

<div id="delConfirmPrice" class="white-popup-block mfp-hide">
	<div class="towns-modal-inner">
		<a href="#" class="mfp-close"></a>
		<div class="confirm">
			Вы действительно хотите удалить данный элемент?
		</div>
		<div class="btnBlock">
			<button id="btnYesPrice">Да</button>
			<button id="btnNo">Нет</button>
		</div>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form-delete-price', 'action' => Url::toRoute('/cabinet/del-vid-price')]);?>
	<input type="hidden" name="id_element" id="id_element_price"> 
<?php ActiveForm::end(); ?>
