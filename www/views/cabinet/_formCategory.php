<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\PriceAbonements */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<table class="table">
		<tr>
			<td>
				Категория родитель:<a href="<?=Url::toRoute(['/cabinet/modal-category', 'id' => $model->id])?>" class="btnParentCategory"><?=$model->parentText?></a>
				<?=Html::activeHiddenInput($model, 'parent_id', ["id" => "parent_id"]);?>
			</td>
		</tr>
		<tr>
			<td><?= $form->field($model, 'name')->textInput();?></td>
		</tr>
		<tr>
			<td><?= $form->field($model, 'sort') ?></td>
		</tr>
		<tr>
			<td>
				<?= $form->field($model, 'image')->fileInput() ?>
				<?if ($model->image_src):?>
					<img src="<?=$model->image_src?>" style="max-width: 50%;">
				<?endif;?>
			</td>
		</tr>
		<tr>
			<td>
				<?= $form->field($model, 'image_detail')->fileInput() ?>
				<?if ($model->image_detail_src):?>
					<img src="<?=$model->image_detail_src?>" style="max-width: 100%;">
				<?endif;?>
			</td>
		</tr>
		<tr>
			<td><?= $form->field($model, 'bool_item')->checkBox() ?></td>
		</tr>
	</table>
	
	<h2 class="title">Родственные категории</h2>
	<a href="<?=Url::toRoute(['/cabinet/modal-category-related', 'id' => $model->id])?>" class="btnParentCategory">Добавить</a>
	<div id="relCategoryBlock">
		<ul id="relCategory">
			<?if ($model->relatedCategory):?>
				<?foreach ($model->relatedCategory as $rel):?>
					<li data-id="<?=$rel->relatedCategoryDetail->id;?>"><?=$rel->relatedCategoryDetail->name;?><span class="delRel">Удалить</span></li>
				<?endforeach;?>
			<?endif;?>
		</ul>
		<input type="hidden" id="urlDelRel" value="<?=Url::toRoute(['/cabinet/delete-related-category', 'id' => $model->id])?>">
	</div>
	<br><br>
	<button>Сохранить</button>
<?php ActiveForm::end(); ?>