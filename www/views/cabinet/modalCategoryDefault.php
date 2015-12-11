<?
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div id="category-modal">
    <div class="towns-modal-inner">
        
        <a href="#" class="mfp-close"></a> 
        <h2>Выберите категорию</h2>
        <br>
        <div class="sel_block">
            <ul class="ulCartegory" data-id="1">
              <?foreach ($category as $cat):?>
                <li data-id="<?=$cat->id;?>">
                    <?=$cat->name;?>
                </li>
              <?endforeach;?>
            </ul>
            <div class="ulChildren">
            </div>
        </div>
        <br>
        <?php $form = ActiveForm::begin(['action' => ['cabinet/add-category-default']]); ?>
            <input type="hidden" id="urlCategory" value="<?=Url::toRoute(['/cabinet/modal-pod-category-default'])?>">
            <input type="hidden" id="id_category" value="0" name="category">
            <button class="selBtn" type="submit" id="setDefaultCategory">Выбрать</button>
        <?php ActiveForm::end(); ?>
    </div><!-- end modal-inner -->
</div> 

