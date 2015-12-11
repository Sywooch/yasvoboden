<?php
    use yii\helpers\Url;
?>

<a class="exit" href="<?=Url::toRoute('/c/logout');?>">Выход</a>
<?if ($user->role == "111"):?>
	<a class="cab" href="<?=Url::toRoute('/user/index');?>" href="#">Личный кабинет</a>
<?elseif ($user->role == "777"):?>
	<a class="cab" href="<?=Url::toRoute('/cabinet/index');?>" href="#">Админка</a>
<?elseif ($user->role == "888"):?>
	<a class="cab" href="<?=Url::toRoute('/user/index');?>" href="#">Личный кабинет</a>
	<a class="cab" href="<?=Url::toRoute('/cabinet/index');?>" href="#">Админка</a>
<?endif;?>
<div class="header-user">
	<p><span><?=$user->login;?></span></p>
</div>