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
                <li data-id="<?=$cat->id;?>" <?if (($cat->id == $r_cat->id) or ($r_cat->is_rel($cat->id))):?>class="disabledRel"<?endif;?>>
                    <?=$cat->name;?>
                </li>
              <?endforeach;?>
            </ul>
            <div class="ulChildren">
            </div>
        </div>
        <br>
        <?php $form = ActiveForm::begin([]); ?>
            <input type="hidden" id="urlCategory" value="<?=Url::toRoute(['/cabinet/modal-pod-category-related', 'id' => $r_cat->id])?>">
            <input type="hidden" id="urlAddRelCategory" value="<?=Url::toRoute(['/cabinet/add-rel-category', 'id' => $r_cat->id])?>">
            <input type="hidden" id="id_category" value="0">
            <button class="selBtn" type="button" id="setParentCategoryRelated">Выбрать</button>
        <?php ActiveForm::end(); ?>
    </div><!-- end modal-inner -->
</div> 

