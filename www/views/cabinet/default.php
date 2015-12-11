<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\PriceAbonements */
/* @var $form yii\widgets\ActiveForm */
?>

<h1>Главная страница</h1>

<div>
	<table>
		<?foreach ($model->imageSlider as $image):?>
			<tr>
				<td><?=$image->image->img?></td>
				<td><a href="<?=Url::toRoute(['/cabinet/del-setting', 'id' => $image->id])?>" >Удалить</a></td>
			</tr>
		<?endforeach;?>
	</table>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?=$form->field($model, 'image_slider')->fileInput()?>
		<button name="addImageSlider" type="submit" value="1">Добавить</button>
	<?php ActiveForm::end(); ?>
</div>

<hr style='border: 1px solid black;'>

<div>
	<h2 class="title">Категории</h2>
	<a href="<?=Url::toRoute(['/cabinet/modal-category-default'])?>" class="btnParentCategory">Добавить</a>
</div>
<table>
	<?foreach($model->categories as $category):?>
		<tr>
			<td><?=$category->category->name?></td>
			<td><a href="<?=Url::toRoute(['/cabinet/del-setting', 'id' => $category->id])?>" >Удалить</a></td>
		</tr>
	<?endforeach;?>
</table>

<hr style='border: 1px solid black;'>

<div>
	<?php $form = ActiveForm::begin(); ?>
		<?=$form->field($model, 'preText')->textInput()?>
		<button name="addPreText" type="submit" value="1">Добавить</button>
	<?php ActiveForm::end(); ?>

	<table>
		<?foreach($model->preTexts as $text):?>
			<tr>
				<td><?=$text->value?></td>
				<td><a href="<?=Url::toRoute(['/cabinet/del-setting', 'id' => $text->id])?>" >Удалить</a></td>
			</tr>
		<?endforeach;?>
	</table>
</div>