<?php
	use yii\helpers\Url;
	use yii\bootstrap\ActiveForm;
?>
<a href="<?=$field->parentCategory->adminUrl?>">Вернуться назад</a>
<br><br>
<h1 class="title">Поле "<?=$field->name;?>"<h1>
<br>

<h1 class="title">Значения<h1>
<a href="<?=Url::toRoute(['/cabinet/add-select', 'id' => $field->id])?>">Добавить</a>

<table class="table">
	<tr>
		<td><b>Значение</b></td>
	</tr>
	<?if ($field->sSelect):?>
		<?foreach ($field->sSelect as $select):?>
			<tr>
				<td><?=$select->value;?></td>
				<td>
					<a href="<?=Url::toRoute(['/cabinet/edit-select', 'id' => $select->id])?>" class="info-edit-btn">редактировать</a><br>
					<a href="#delConfirm" class="del_rec info-del-btn" data-id="<?=$select->id;?>">удалить</a>
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
			<button id="btnYesSelect">Да</button>
			<button id="btnNo">Нет</button>
		</div>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form-delete-select', 'action' => Url::toRoute('/cabinet/del-select')]);?>
	<input type="hidden" name="id_element" id="id_element"> 
<?php ActiveForm::end(); ?>
