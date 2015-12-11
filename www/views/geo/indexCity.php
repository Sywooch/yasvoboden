<?php
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;
	use yii\widgets\Breadcrumbs;
?>

<h1 class="title">Города региона "<?=$region->name;?>"</h1>
<a href="<?=Url::toRoute(['/geo/index'])?>">Округа</a>
<a href="<?=Url::toRoute(['/geo/index-region', 'id' => $region->id_okrug])?>">Регионы</a>
<br>
<a href="<?=Url::toRoute(['/geo/create-city', "id" => $region->id])?>" class="admBtn">Добавить город</a>

<?if (count($cityes) > 0):?>
	<table class="table">
		<tr>
			<td>Название</td> 
		</tr>
		<?foreach($cityes as $city):?>
			<tr>
				<td><?=$city->name;?></td>
				<td>
					<a href="<?=Url::toRoute(['/geo/edit-city', 'id' => $city->id])?>" class="info-edit-btn">редактировать</a><br>
					<a href="#delConfirm" class="del_rec info-del-btn" data-id="<?=$city->id?>">удалить</a>
				</td>
			</tr>
		<?endforeach;?>
	</table>
<?else:?>
	<p>Нет ни одного элемента!</p>
<?endif;?>

<div id="delConfirm" class="white-popup-block mfp-hide">
	<div class="towns-modal-inner">
		<a href="#" class="mfp-close"></a>
		<div class="confirm">
			Вы действительно хотите удалить данный элемент?
		</div>
		<div class="btnBlock">
			<button id="btnYesCity">Да</button>
			<button id="btnNo">Нет</button>
		</div>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form-delete-city', 'action' => Url::toRoute('/geo/delete-city')]);?>
	<input type="hidden" name="id_element" id="id_element"> 
<?php ActiveForm::end(); ?>
 	