<?php 

	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;

?>
<a class="cab modal-authorization" href="#modal-authorization" href="#">Авторизация</a>
<a class="cab" href="<?=Url::toRoute('/user/register');?>">Регистрация</a>

<div id="modal-authorization" class="white-popup-block mfp-hide">
	<div class="modal-authorization-inner">
		<h2>Авторизация</h2>
		<a href="#" class="mfp-close"></a>
		<?php $form = ActiveForm::begin([
			'id' => 'form-authorization',
			'options' => ['action' => ''],
		]);?>
			<div class="form-authorization-row">
				<div>
					<label for="">логин</label>
				</div>
				<div>
					<?= Html::activeTextInput($loginForm, 'username') ?>
				</div>
			</div>
			<div class="form-authorization-row">
				<div>
					<label for="">пароль</label>
				</div>
				<div>
					<?= Html::activePasswordInput($loginForm, 'password') ?>
				</div>
			</div>
			<div class="form-authorization-row">
				<div>
					
				</div>
				<div>
					<input type="submit" value="Вход" name="auth" id="btnAuth">
				</div> 
			</div>
			<div class="form-authorization-row">
				<div>
					
				</div>
				<div style="width: 100%; text-align: center;">
					<a href="#forgout" class="forgout">Забыли пароль</a>
				</div> 
			</div>
			<div class="errorAuth"></div>
			<input type="hidden" id="formUrl" value="<?=Url::toRoute('/c/auth-ajax')?>">
		<?php ActiveForm::end(); ?>
	</div><!-- end modal history inner -->
	
</div>

<div id="forgout" class="white-popup-block mfp-hide">
	<div class="modal-authorization-inner">
		<h2>Забыли пароль</h2>
		<a href="#" class="mfp-close"></a>
		<?php $form = ActiveForm::begin([
			'id' => 'form-forgout',
			'options' => ['action' => ''],
		]);?>
			<div class="form-authorization-row">
				<div>
					<label for="">Укажите Ваш email</label>
				</div>
				<div>
					<?= Html::activeTextInput($ForgoutForm, 'email') ?>
				</div>
			</div>
			<div class="form-authorization-row">
				<div>
					
				</div>
				<div>
					<input type="submit" value="Отправить" name="send" id="send_forgout">
				</div> 
			</div>
			<div class="errorAuthForgout" style="color: red;"></div>
			<input type="hidden" id="formUrlForgout" value="<?=Url::toRoute('/c/forgout-ajax')?>">
		<?php ActiveForm::end(); ?>
	</div><!-- end modal history inner -->
	
</div>

<?php
    $this->registerJsFile(
        'js/authForm.js',
        ['depends'=>'app\assets\AppAsset'] 
    );
?>
