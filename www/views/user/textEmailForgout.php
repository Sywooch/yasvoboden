<?php

	use yii\helpers\Url;

?>

<h1>Восстановление пароля</h1>
<p>
	Для восстановления пароля перейдите по ссылке 
	<a href="<?=Yii::$app->urlManager->createAbsoluteUrl(['/site/forgout', 'token' => $token, 'login' => $login, 'id_user' => $id_user])?>">
		<?=Yii::$app->urlManager->createAbsoluteUrl(['/site/forgout', 'token' => $token, 'login' => $login, 'id_user' => $id_user])?>
	</a>
</p>
<p>
	Если вы не забывали свой пароль, тогда проигнорируйте данное сообщение! 
</p>