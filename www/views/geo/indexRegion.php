<?php
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;
	use yii\widgets\Breadcrumbs;
?>

<h1 class="title">Регионы округа "<?=$okrug->name;?>"</h1>
<a href="<?=Url::toRoute(['/geo/index'])?>">Округа</a>

<a href="<?=Url::toRoute(['/geo/create-region', "id" => $okrug->id])?>" class="admBtn">Добавить регион</a>

<?if (count($regions) > 0):?>
	<table class="table">
		<tr>
			<td>Название</td> 
		</tr>
		<?foreach($regions as $region):?>
			<tr>
				<td><a href="<?=Url::toRoute(['/geo/index-city', 'id' => $region->id])?>"><?=$region->name;?></a></td>
				<td>
					<a href="<?=Url::toRoute(['/geo/edit-region', 'id' => $region->id])?>" class="info-edit-btn">редактировать</a><br>
					<a href="#delConfirm" class="del_rec info-del-btn" data-id="<?=$region->id?>">удалить</a>
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
			<button id="btnYesRegion">Да</button>
			<button id="btnNo">Нет</button>
		</div>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form-delete-region', 'action' => Url::toRoute('/geo/delete-region')]);?>
	<input type="hidden" name="id_element" id="id_element"> 
<?php ActiveForm::end(); ?>
 	