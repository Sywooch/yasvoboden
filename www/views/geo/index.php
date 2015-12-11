<?php
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;
	use yii\widgets\Breadcrumbs;
?>

<h1 class="title">Округа</h1>
<a href="<?=Url::toRoute(['/geo/create-okrug'])?>" class="admBtn">Добавить округ</a>

<?if (count($okrugs) > 0):?>
	<table class="table">
		<tr>
			<td>Название</td> 
		</tr>
		<?foreach($okrugs as $okrug):?>
			<tr>
				<td><a href="<?=Url::toRoute(['/geo/index-region', 'id' => $okrug->id])?>"><?=$okrug->name;?></a></td>
				<td>
					<a href="<?=Url::toRoute(['/geo/edit-okrug', 'id' => $okrug->id])?>" class="info-edit-btn">редактировать</a><br>
					<a href="#delConfirm" class="del_rec info-del-btn" data-id="<?=$okrug->id?>">удалить</a>
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
			<button id="btnYesOkrug">Да</button>
			<button id="btnNo">Нет</button>
		</div>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form-delete-okrug', 'action' => Url::toRoute('/geo/delete-okrug')]);?>
	<input type="hidden" name="id_element" id="id_element"> 
<?php ActiveForm::end(); ?>
 	