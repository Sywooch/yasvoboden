<?php
	
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;

?>
<section id="main" class="top25px">
	<div class="container">
		

		<div class="cat cat-personal-cab" style="background:url(./images/bg/cat-personal.jpg);">
			<div class="cab-left-edit">
				<h1 class="cat-personal-cab-heading">Редактирование пользователя</h1>
			</div><!-- end cat-left -->
		</div><!-- end cat -->

		<div class="registration-wrap-edit">
			<div class="successMsg"><?=$msg;?></div>
			<?php $form = ActiveForm::begin([
				'id' => 'registration-form',
				'options' => ['action' => ''],
			]);?>
				<div class="registration-form-left">
					<div class="registration-form-left-inner">
						<div class="registration-form-row">
							<div><label for="">Город</label></div>
							<div>
								<a class="<?=$user->getError('id_city', false);?> popup-modal select-town" href="<?=Url::toRoute('/user/modal-city');?>" id="cityName">
									<?if ($user->id_city == ""):?>Выберите свой город<?else:?><?=$user->city->name?><?endif;?>
								</a>
							</div>
							<?= Html::activeHiddenInput($user, 'id_city', ['id' => 'id_city_register']) ?>
						</div><!-- end row -->
						<div class="registration-form-row"> 
							<div><label for="">Имя</label></div>
							<div><?= Html::activeTextInput($user, 'name', ['class' => $user->getError('name')]) ?></div>
						</div><!-- end row -->
						<div class="registration-form-row">
							<div><label for="">Фамилия</label></div>
							<div><?= Html::activeTextInput($user, 'surname', ['class' => $user->getError('surname')]) ?></div>
						</div><!-- end row -->
						<div class="registration-form-row">
							<div><label for="">E-mail</label></div>
							<div><?= Html::activeTextInput($user, 'email', ['class' => $user->getError('email')]) ?></div>
						</div><!-- end row -->
						<div class="registration-form-row">
							<div><label for="">Телефон</label></div>
							<div><?= Html::activeTextInput($user, 'phone', ['class' => $user->getError('phone')]) ?></div>
						</div><!-- end row -->
						<div class="registration-form-row">
							<div><label for="">Логин</label></div>
							<div><?= Html::activeTextInput($user, 'login', ['class' => $user->getError('login')]) ?></div>
						</div><!-- end row -->
						<div class="registration-form-row">
							<div></div>
							<div><p>все поля обязательны к заполнению</p></div>
						</div><!-- end row -->
						<div class="registration-form-row">
							<div></div>
							<div><input class="btn-disabled" type="submit" value="Сохранить" name="editUser"></div>
						</div><!-- end row -->
						<div class="registration-form-row">
							<div></div>
							<div>
								<?if (count($user->errors) > 0):?>
									<div class="error-wrap">
										<?foreach ($user->errors as $error_field):?>
											<?foreach($error_field as $error):?>
												<em><?=$error;?></em>
											<?endforeach;?>
										<?endforeach;?>
									</div>
								<?endif;?>
							</div>
						</div><!-- end row -->
						</div>
					</div><!-- end left -->
				<div class="registration-form-center">
					
					<div class="registration-form-row">
						<div><label for="" style="width: 100%; text-align: center; display: block;">Изменение пароля</label></div>
					</div><!-- end row -->
					<div class="registration-form-row">
						<div><label for="">Пароль</label></div>
						<div><?= Html::activePasswordInput($user_pass, 'password', ['class' => $user->getError('password')]) ?></div>
					</div><!-- end row -->
					<div class="registration-form-row">
						<div><label for="">Подтверждение пароля</label></div>
						<div><?= Html::activePasswordInput($user_pass, 'password_repeat', ['class' => $user->getError('password_repeat')]) ?></div> 
					</div><!-- end row -->
					<div class="registration-form-row">
						<div></div>
						<div><input class="btn-disabled" type="submit" value="Изменить" name="editPassword"></div>
					</div><!-- end row -->
					<div class="registration-form-row">
						<div></div>
						<div>
							<?if (count($user_pass->errors) > 0):?>
								<div class="error-wrap">
									<?foreach ($user_pass->errors as $error_field):?>
										<?foreach($error_field as $error):?>
											<em><?=$error;?></em>
										<?endforeach;?>
									<?endforeach;?>
								</div>
							<?endif;?>
						</div>
					</div><!-- end row -->
				</div><!-- end center -->
				<div class="registration-form-right"></div><!-- end right -->

			<?php ActiveForm::end(); ?>
		</div><!-- end registration -->
		
	</div><!-- end container -->
</section><!-- end main -->