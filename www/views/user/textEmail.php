<?php

	use yii\helpers\Url;

?>

<h1>Потверждение регистрации</h1>
<p>
	Для потверждения перейдите по ссылке 
	<a href="<?=Yii::$app->urlManager->createAbsoluteUrl(['/user/activate-user-email', 'token' => $token])?>">
		<?=Yii::$app->urlManager->createAbsoluteUrl(['/user/activate-user-email', 'token' => $token])?>
	</a>
</p>
<p>
	Для отказа от регистрации перейдите по ссылке 
	<a href="<?=Yii::$app->urlManager->createAbsoluteUrl(['/user/disabled-user-email', 'token' => $token])?>">
		<?=Yii::$app->urlManager->createAbsoluteUrl(['/user/disabled-user-email', 'token' => $token])?>
	</a>
</p>