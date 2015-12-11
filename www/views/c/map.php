<?php
	use yii\helpers\Url;
?>

<a href="<?=Url::toRoute(['/c/ymap', 'coord' => $field->value])?>" style="color: #616161;" class="ymap">Открыть карту</a>


