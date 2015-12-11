<?php
	
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;

	$this->title = 'Личный кабинет';
?>

<section id="main" class="top25px">
	<div class="container">
		

		<?=$this->render('userBlock', ['user' => $user]);?>

		<section id="personal-cab-info">
			<ul class="personal-info-links">
				<li><a class="info-active" href="<?=Url::toRoute('/user/index')?>">Профиль</a></li>
				<li><a href="<?=Url::toRoute('/user/modal-category')?>" class="modal-addrecord">Добавить предложение</a></li> 
				<li><a class="modal-history" href="<?=Url::toRoute('/user/modal-history')?>">История операций</a></li>
				<li><a class="modal-feedback" href="#modal-feedback">Обратная связь</a></li>
			</ul>

			<?foreach ($items as $item):?>
				<div class="info-row">
					<div class="info-sms">
						<div class="info-sms-inner">
							<b style="font-weight: bold; margin-bottom: 10px; display: block;"><?=$item->geo;?></b>
							<a class="sms-btn <?if ($item->isStatus):?>btn-enable<?else:?>btn-disable<?endif;?>" href="<?=Url::toRoute(['/user/activate-record', 'id' => $item->id])?>">
								<?=$item->isStatusText;?>
							</a>
							<p class="info-number">ЯСВ <?=$item->id;?></p><!-- end info-number -->
							<a class="sms-btn btn-send" href="<?=Url::toRoute(['/user/send-sms', 'id' => $item->id])?>">Отправить sms</a>
							<p class="sms-desc">отправить sms с уникальным номером обЪявления на номер</p>
							<p><?=$user->phone?></p>
							<p class="sms-desc"><?=$item->endTime;?></p>
						</div>
					</div><!-- end  sms -->
					<div class="info-img">
						<div class="info-img-inner">
							<!-- <a href="#"><img src="images/all/product-car.jpg" alt="квартира"></a> -->
							<div class="lightgallery">
							  	<?$class = "";?>
								<?foreach ($item->images as $image):?>
									<a href="<?=$image->src?>">
									    <img src="<?=$image->src?>" <?=$class;?>/>
								    </a>
									<?$class = "class='hide'";?>
								<?endforeach;?>
							</div>
						</div>
					</div>
					<div class="info-product">
						<div class="info-product-inner">
							<h4><?=$item->name?></h4>
							<div class="info-product-row">
								<div class="info-product-left">
									<p>цена</p>
								</div>
								<div class="info-product-right">
									<?foreach ($item->prices as $price):?>
										<p><?=$price->value?> <?=$price->unit->name?></p>
									<?endforeach;?>
								</div>
							</div><!-- end filter-product-row -->
							<div class="info-product-row">
								<div class="info-product-left">
									<strong>Телефон</strong>
								</div>
								<div class="info-product-right">
									<b style="font-weight: bold;"><?=$item->phone;?></b>
								</div>
							</div><!-- end filter-product-row -->
						</div>
					</div><!-- end filter-product -->
					<div class="info-desc">
						<div class="info-desc-inner">
							<p><?=$item->description?></p>
						</div>
					</div><!-- end info-desc -->
					<div class="info-data">
						<div class="info-data-inner"> 
							<?foreach ($item->fields as $field):?>
								<div class="filter-data-inner-row">
									<p><?=$field->typeField->name;?></p>
									<p><span><?=$field->val;?></span> <?=$field->typeField->unit;?></p>
								</div>
							<?endforeach;?>
						</div>
					</div><!-- end info-data -->
					<div class="info-edit">
						<span style="font-weight: bold; display: block; padding: 5px; margin-bottom: 15px;"><?=$item->catName?></span>
						<a href="<?=Url::toRoute(['/user/edit-record', 'id' => $item->id])?>" class="info-edit-btn">редактировать</a>
						<a href="#delConfirm" class="del_rec info-del-btn" data-id="<?=$item->id?>">удалить</a>
						<a href="<?=Url::toRoute(['user/modal-plan', 'id' => $item->id])?>" class="info-plan-btn" data-id="<?=$item->id?>">Планировщик</a>
					</div><!-- end info edit -->
					<?if ($item->isShowBtn(600) or (count($item->fields) > 9)):?>
						<div class="showHidden"><a href="#" id="showBlock">Развернуть</a></div>
					<?endif?>
				</div><!-- end info-row --> 
			<?endforeach;?>

		</section><!-- end personal-info -->

		<div class="pagination">
			<?=LinkPager::widget(['pagination' => $pages,]);?>
		</div>
		
	</div><!-- end container -->
</section><!-- end main -->

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

<?=$this->render('modalFeedback', ['Feedback' => $Feedback]);?>

<div id="addMoney" class="white-popup-block mfp-hide">
	<div class="towns-modal-inner">
		<a href="#" class="mfp-close"></a>
		<h3>Какую сумму вы хотите внести?</h3>
		<?php $form = ActiveForm::begin(['id' => 'add-money-form', 'action' => Url::toRoute('/user/add-money')]);?>
			<input type="text" name="sum">
			<input type="submit" value="Пополнить"> 
		<?php ActiveForm::end(); ?>
	</div>
</div>

<?php $form = ActiveForm::begin(['id' => 'hidden-form', 'action' => Url::toRoute('/user/del-record')]);?>
	<input type="hidden" name="id_element" id="id_element"> 
<?php ActiveForm::end(); ?>
 	
<?php
    $this->registerJsFile(
        'js/profile_index.js',
        ['depends'=>'app\assets\AppAsset'] 
    );
?>

<?if ($errorMsg):?>
	<script>
		alert("<?=$errorMsg;?>");
	</script>
<?endif;?>

<?if ($successMsg):?>
	<script>
		alert("<?=$successMsg;?>");
	</script>
<?endif;?>

<? $this->registerJsFile(
        'js/jquery.inputmask.bundle.js',
        ['depends'=>'app\assets\AppAsset'] 
    );
?>





