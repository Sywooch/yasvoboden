<?
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div id="towns-modal">
    <div class="towns-modal-inner">
        <input type="hidden" id="pod_category" value="<?=Url::toRoute('user/pod-category');?>">
        
        <a href="#" class="mfp-close"></a> 
        <h2>Выберите категорию</h2>
        <div class="towns">
            <div class="modal-category" id="sel_block">
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
            </div>
        </div><!-- end towns -->
        <input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" name="_csrf"/>
        <?php $form = ActiveForm::begin(['action' => Url::toRoute('user/add-record'), 'method' => 'get']); ?>
            <input type="hidden" id="id_category" name="id_category">
            <input type="submit" class="disabled choose" value="Выбрать" id="setCategory">
        <?php ActiveForm::end(); ?>
    </div><!-- end modal-inner -->
</div> 