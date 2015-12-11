<?
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;
	use kartik\file\FileInput;
	use yii\helpers\Html;
?>

<style>
	.info-row div
	{
		max-height: none !important;
	}
</style>
 
<section id="main" class="top25px">
	<div class="container">
		

		<?=$this->render('userBlock', ['user' => $user]);?>
		<a href="<?=Url::toRoute('user/index');?>" class="backLK">Вернуться в личный кабинет</a>
		<section id="insert">
			<h1 style="font-weight: bold; font-size: 18px;">Категория "<?=$cat->name?>"</h1>
			<div class="info-row">
				
				<div class="info-img left80px">
					<div class="info-img-inner ">
						<div class="lightgallery">
						  	<?$class = "";?>
							<?foreach ($model->images as $image):?>
								<a href="<?=$image->src?>">
								    <img src="<?=$image->src?>" <?=$class;?>/>
							    </a>
								<?$class = "class='hide'";?>
							<?endforeach;?>
						</div>
					</div>
				</div>
				<div class="info-product">
					<div class="info-product-inner ">
						<h4 v-html="name"></h4>
						<div class="info-product-row">
							<div class="info-product-left">
								<p>цена</p>
							</div>
							<div class="info-product-right">
								<?foreach ($model->typesPrice as $tprice):?>
									<p><span>{{price<?=$tprice->id;?>}}</span> <?=$tprice->name?></p>
								<?endforeach;?>
							</div>
						</div><!-- end filter-product-row -->
						<div class="info-product-row">
							<div class="info-product-left">
								<p>Телефон</p>
							</div>
							<div class="info-product-right phone" v-html="phone">
							</div>
						</div><!-- end filter-product-row -->
					</div>
				</div><!-- end filter-product -->

				<div class="mes-text">
					<div class="mes-text-inner">
						<pre><p>{{text_area}}</p></pre>
					</div><!-- end mes-text-inner -->
				</div><!-- end mes-text -->

				<div class="form-data">
					<div class="form-data-inner">
						<?foreach ($model->typesField as $tfield):?>
							<div>
								<p><?=$tfield->name;?></p>
								<p>{{field<?=$tfield->id;?> | formatter "field<?=$tfield->id;?>"}}</p>
							</div>
						<?endforeach;?>
					</div><!-- end data-inner -->
				</div><!-- end form-data -->
				
			</div><!-- end info-row -->
		</section><!-- end personal-info -->

		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'insert-form']]); ?>
			<div class="insert-row-bg">
				<div class="insert-form-row">
					<div class="insert-form-left">
						<div class="insert-form-left-inner">
							<div class="input-wrap">
								<div>
									<label for="">Название объявления</label>
								</div>
								<div>
									<?= Html::activeTextInput($model, 'name', ['v-model' => "name"]) ?>
								</div>
							</div><!-- end wrap -->
							<div class="input-wrap">
								<div>
									<label for="">Текст объявления</label>
								</div>
								<div>
									<?= Html::activeTextArea($model, 'text', ['v-model' => "text_area"]) ?>
								</div>
							</div><!-- end wrap -->
							<div class="input-wrap">
								<div>
									<label for="">Цена</label>
								</div>
								<div>
									<?foreach ($model->typesPrice as $tprice):?>
										<div class="priceBlock general"> 
											<?= Html::activeTextInput($model, 'price['.$tprice->id.']', ['class' => ["priceText"], 'v-model' => "price".$tprice->id]) ?>
											<label><?=$tprice->name;?></label>
										</div>
									<?endforeach;?>
								</div>
							</div><!-- end wrap -->
							<div class="input-wrap">
								<div>
									<label for="">Телефон</label>
								</div>
								<div>
									<?= Html::activeTextInput($model, 'phone', ['class' => 'phone', 'v-model' => "phone"]) ?>
								</div>
							</div><!-- end wrap -->
							<div class="input-wrap">
								<div>
									<label for="">Фото</label>
								</div>
								<div>
									<span class="podskazka">* Вы можете сохранить несколько фото выделяя их все при выборе.</span>
									<?=FileInput::widget([
											'name' => 'attachments',
										    'model' => $model,
										    'attribute' => 'image[]',
										    'options' => ['multiple' => true],
										    'pluginOptions' => ['previewFileType' => 'any', 
										    					'showRemove' => false,
                 												'showUpload' => false,
                 												] 
										]);
									?> 

									<table class="imgClass">
										<?foreach ($model->images as $image):?>
											<?if ($image->id != 1):?>
												<tr>
													<td><img src="<?=$image->src?>" style="max-width: 150px;"/></td>
													<td><a href="#delConfirm" class="del_rec info-del-btn" data-id="<?=$image->id?>">удалить</a></td>
												</tr>
											<?endif;?>
										<?endforeach;?> 
									</table>
								</div>
							</div><!-- end wrap -->
						</div><!-- end inner -->
					</div><!-- end form-left -->
					<div class="insert-form-right">
						<div class="insert-form-right-inner">
							<div class="input-wrap">
								<div>
									<label for="">Город</label>
								</div>
								<div>
									<a class="popup-modal select-town" href="<?=Url::toRoute('user/modal-city-new-record');?>" id="b_city"><?=$model->cityName?></a>
									<?= Html::activeHiddenInput($model, 'id_city', ['id' => 'id_city_record']) ?>
								</div>
							</div><!-- end wrap -->
							<?foreach ($model->typesField as $tfield):?>
								<div class="input-wrap"> 
									<div>
										<label for=""><?=$tfield->name;?></label>
									</div>
									<div>
										<?=$tfield->getEditInput($model, 'field['.$tfield->id.']', ['v-model' => 'field'.$tfield->id, 'data-id' => 'field'.$tfield->id])?>
									</div>
								</div><!-- end wrap -->
							<?endforeach;?>
							<div class="input-wrap">
								<div>
									
								</div>
								<div>
									<input type="submit" value="Сохранить объявление">
								</div>
							</div><!-- end wrap -->
							<div class="input-wrap">
								<div>
									
								</div>
								<div class="error">
									<?if ($model->errors):?>
										<?foreach ($model->errors as $error_field):?>
											<?foreach ($error_field as $error):?>
												<p><?=$error?></p>
											<?endforeach;?>
										<?endforeach;?>
									<?endif;?>
								</div>
							</div><!-- end wrap -->
						</div>
					</div><!-- end form-right -->
				</div><!-- end form-row -->
			</div>
			
		<?php ActiveForm::end(); ?>
		
	</div><!-- end container -->
</section><!-- end main -->

<?php
    $this->registerJsFile(
        'js/profile_index.js',
        ['depends'=>'app\assets\AppAsset'] 
    );

    $this->registerJsFile(
        'js/jquery.inputmask.bundle.js',
        ['depends'=>'app\assets\AppAsset'] 
    );
?>

<script>
	new Vue({
	  el: '#main',
	  data: {
	    name: '',
	    phone: '',
	    text_area: '',
	    <?foreach ($model->typesField as $tfield):?>
	    	field<?=$tfield->id;?>: "",
		<?endforeach;?>
		<?foreach ($model->typesPrice as $tprice):?>
			price<?=$tprice->id;?>: "",
		<?endforeach;?>
	  },
	  filters:
	  {
	  	formatter: function(val, id)
		  	{
		  		var newVal = val;
		  		v = $("select[data-id = '"+id+"'] option[value='"+val+"']").html();

		  		if (v)
		  			newVal = v;

		  		return newVal;
		  	}
	  }
	});

	$(document).ready(function(){
	   $(".priceText").inputmask({ "mask": "9", "repeat": 10, "greedy": false });
	   $(".phone").inputmask("+7 (999) 9 999 999");
	});
</script>

<div id="delConfirm" class="white-popup-block mfp-hide">
	<div class="towns-modal-inner">
		<a href="#" class="mfp-close"></a>
		<div class="confirm">
			Вы действительно хотите удалить данный элемент?
		</div>
		<div class="btnBlock">
			<button id="btnYesImage">Да</button>
			<button id="btnNo">Нет</button>
		</div>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form-del-image']);?>
	<input type="hidden" id="urlImage" value="<?=Url::toRoute('user/delete-image')?>"> 
<?php ActiveForm::end(); ?>