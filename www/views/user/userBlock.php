<?php
	
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\bootstrap\ActiveForm;
	use yii\widgets\Breadcrumbs;
?>

<div class="cat cat-personal-cab" style="background:url(./images/bg/cat-personal.jpg);">
	<div class="cab-left">
		<h1 class="cat-personal-cab-heading"><?=$this->title?></h1>
	</div><!-- end cat-left -->
	<div class="cab-data">
		<div class="cab-data-row">
			<div class="cab-data-left"><p>город</p></div>
			<div class="cab-data-right"><p><?=$user->city->name;?></p></div>
		</div><!-- end row -->
		<div class="cab-data-row">
			<div class="cab-data-left"><p>имя</p></div>
			<div class="cab-data-right"><p><?=$user->name;?></p></div>
		</div><!-- end row -->
		<div class="cab-data-row">
			<div class="cab-data-left"><p>фамилия</p></div>
			<div class="cab-data-right"><p><?=$user->surname;?></p></div>
		</div><!-- end row -->
		<div class="cab-data-row">
			<div class="cab-data-left"><p>e-mail</p></div>
			<div class="cab-data-right"><p><?=$user->email;?></p></div>
		</div><!-- end row -->
		<div class="cab-data-row">
			<div class="cab-data-left"><p>телефон</p></div>
			<div class="cab-data-right"><p><?=$user->phone;?></p></div>
		</div><!-- end row -->
	</div><!-- end cat-data -->
	<div class="cab-edit">
		<a href="<?=Url::toRoute('user/edit-user');?>">Редактировать</a>
	</div><!-- end cat-edit -->
	<div class="cab-account">
		<p>На Вашем счету</p>
		<p><?=$user->money;?> <span></span></p>
		<a href="#addMoney" class="addMoney">Пополнить</a>
	</div><!-- end cat-account -->

</div><!-- end cat -->