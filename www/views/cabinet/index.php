<?php
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;
	use yii\widgets\Breadcrumbs;
?>

<h1 class="title">Категории</h1>
<a href="<?=Url::toRoute(['/cabinet/add-category', 'id' => $id])?>" class="admBtn">Добавить категорию</a>
<?= Breadcrumbs::widget([ 
	 'homeLink' => ['label' => 'Главная', 'url' => ['cabinet/index']],
	 'links' => isset($params['breadcrumbs']) ? $params['breadcrumbs'] : [],
]) ?>
<?if (count($category) > 0):?>
	<table class="table">
		<tr>
			<td>ID</td>
			<td>Название</td>
			<td>Логотип</td>
			<td>Конечный</td>
			<td>Действия</td>
		</tr>
		<?foreach($category as $cat):?>
			<tr>
				<td><?=$cat->id;?></td>
				<td><a href="<?=$cat->adminUrl?>"><?=$cat->name;?></a></td>
				<td><img src="<?=$cat->images['src'];?>" alt="<?=$cat->name;?>" class="admin_img"></td>
				<td>
					<?if ($cat->bool_item == 1):?>
						Да
					<?else:?> 
						Нет
					<?endif;?>
				</td>
				<td>
					<a href="<?=Url::toRoute(['/cabinet/edit-category', 'id' => $cat->id])?>" class="info-edit-btn">редактировать</a><br>
					<a href="#delConfirm" class="del_rec info-del-btn" data-id="<?=$cat->id?>">удалить</a>
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
			<button id="btnYes">Да</button>
			<button id="btnNo">Нет</button>
		</div>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form', 'action' => Url::toRoute('/cabinet/del-category')]);?>
	<input type="hidden" name="id_element" id="id_element"> 
<?php ActiveForm::end(); ?>
 	