<?
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div id="towns-modal">
    <div class="towns-modal-inner">
    <input type="hidden" id="u_regions" value="<?=Url::toRoute('c/regions');?>">
    <input type="hidden" id="u_cityes" value="<?=Url::toRoute('c/cityes');?>">
    
    <a href="#" class="mfp-close"></a>
        <h2>Выберите свой город</h2>
        <div class="towns">
            <div class="modal-left">
                <h3>Федеральные округа</h3>
                <ul id="s_okrug">
                    <?foreach ($okrugs as $okrug):?>
                        <li>
                            <a href="#" data-id="<?=$okrug->id?>" <?if ($this->context->geo->id_okrug == $okrug->id):?>class="okrug-active"<?endif?>>
                                <?=$okrug->name?>
                            </a>
                        </li>
                    <?endforeach;?>
                </ul><!-- end left -->
            </div>
            <div class="modal-center">
                <h3>Регионы</h3>
                <ul id="s_region">
                     <?if ($regions):?>
                        <?foreach ($regions as $region):?>
                            <li>
                                <a href="#" data-id="<?=$region->id?>" <?if ($this->context->geo->id_region == $region->id):?>class="republic-active"<?endif?>>
                                    <?=$region->name?>
                                </a>
                            </li>
                        <?endforeach;?>
                    <?endif;?>
                </ul><!-- end center -->
            </div> 
            <div class="modal-right">
                <h3>Города</h3>
                <ul id="s_city">
                    <?if ($cityes):?>
                        <?foreach ($cityes as $city):?>
                            <li>
                                <a href="#" data-id="<?=$city->id?>"  <?if ($this->context->geo->id_city == $city->id):?>class="town-active"<?endif?>>
                                    <?=$city->name?>
                                </a>
                            </li>
                        <?endforeach;?>
                    <?endif;?>
                </ul><!-- end right -->
            </div>
        </div><!-- end towns -->
        
        <input type="hidden" id="id_city">
        <input type="hidden" id="id_region">
        <input type="hidden" id="id_okrug">
        <input type="button" class="choose" value="Выбрать" id="setCityNewRecord">

    </div><!-- end modal-inner -->
</div> 