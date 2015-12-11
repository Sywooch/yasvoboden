<?
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<h3><?=$cat->name;?></h3>
<ul>
    <?foreach ($categoryes as $cat):?>
        <li <?if ($cat->bool_item == 1):?>class='success'<?endif;?>>
            <a href="#" data-id="<?=$cat->id?>">
                <?=$cat->name?>
            </a>
        </li>
    <?endforeach;?>
</ul><!-- end left -->
<div class="modal-category ulCategory">
</div>
      