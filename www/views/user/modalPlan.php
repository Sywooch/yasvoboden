<?
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div id="towns-modal">
        
        <div class="modal-offer-wrap">
    
        <?php $form = ActiveForm::begin(['id' => 'offer-form']); ?>
            <h2>ПРЕДЛОЖЕНИЕ <span>YASV <?=$item->id?></span></h2>
            <a href="#" class="mfp-close"></a>
            <div class="offer-info-wrap"><span class="offer-info"></span></div>
            <div class="offer-attention">Внимание!</div>
            <div class="offer-attention">Сумма оплаты будет списана в момент активации.</div>
            <div class="offer-attention">В случае отсутствия необходимой суммы все настройки будут сброшены.</div>
            <div class="offer-radio-wrap">
                <div>
                    <label for="offer-custom">По дням недели</label>
                </div>
            </div>
            <div class="offer-week-wrap">
                <input type="checkbox" class="offer-day-chb" <?if (isset($weeks[1])):?> checked="checked" <?endif;?> name="week[]" id="mon" value="1">
                <label for="mon"></label>
                <input type="checkbox" class="offer-day-chb" <?if (isset($weeks[2])):?> checked="checked" <?endif;?> name="week[]" id="tue" value="2">
                <label for="tue"></label>
                <input type="checkbox" class="offer-day-chb" <?if (isset($weeks[3])):?> checked="checked" <?endif;?> name="week[]" id="wed" value="3">
                <label for="wed"></label>
                <input type="checkbox" class="offer-day-chb" <?if (isset($weeks[4])):?> checked="checked" <?endif;?> name="week[]" id="thu" value="4">
                <label for="thu"></label>
                <input type="checkbox" class="offer-day-chb" <?if (isset($weeks[5])):?> checked="checked" <?endif;?> name="week[]" id="fri" value="5">
                <label for="fri"></label>
                <input type="checkbox" class="offer-day-chb" <?if (isset($weeks[6])):?> checked="checked" <?endif;?> name="week[]" id="sat" value="6">
                <label for="sat"></label>
                <input type="checkbox" class="offer-day-chb" <?if (isset($weeks[0])):?> checked="checked" <?endif;?> name="week[]" id="sun" value="0"> 
                <label for="sun"></label>
                <div class="clear"></div>
            </div>
            <div class="offer-act-time-wrap">
                <div class="offer-attention">Время активации</div>
                <input type="text" value="<?=date('H:i')?>" name="time" class="offer-act-time">
            </div>
        
            <div class="offer-buttons">
                <input class="submit-on" type="submit" value="Сохранить" name="save"> <br/>
                <input class="submit-off" type="submit" value="Отключить и сбросить настройки" style="margin-top: 20px;">
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    </div><!-- end modal-inner -->
</div> 

<script type="text/javascript">
    $(document).ready(function(){
       $(".offer-act-time").inputmask({"mask": "h:sе5ь"});
    });
    
</script>

<style>

.modal-offer-wrap {
    position: fixed;
    width: 725px;
    height: 485px;
    background-color: #eee;
    left: 50%;
    top: 50%;
    margin-left: -362px;
    margin-top: -242px;
    font-family: Roboto;
    padding: 40px;
    box-sizing: border-box;
}

.modal-offer-wrap button{
    cursor: pointer;
}
.modal-offer-wrap h2 {
    font-size: 25px;
    color: #36343b;
    text-align: center;
    margin: 0;
}
span.offer-info {
    background: url(offer-controls.png) 0 0 no-repeat;
    width: 29px;
    height: 29px;
    display: inline-block;
}
.modal-offer-wrap .offer-buttons {
    text-align: center;
}
.modal-offer-wrap .offer-info-wrap {
    text-align: center;
    margin: 15px 0 5px;
}
.modal-offer-wrap .offer-attention {
    font-size: 13px;
    color: #616161;
    text-align: center;
    line-height: 20px;
}
.modal-offer-wrap .offer-radio-wrap > div {
    padding-left: 251px;
    font-size: 14px;
    margin-bottom: 10px;
}
.modal-offer-wrap .offer-radio-wrap {
    margin: 25px 0 10px;
}
.modal-offer-wrap .offer-week-wrap {
    margin: 0 auto 35px;
    width: 295px;
}



.modal-offer-wrap .offer-act-time-wrap {
    text-align: center;
    margin-bottom: 35px;
}
.modal-offer-wrap input.offer-act-time {
    width: 90px;
    height: 30px;
    margin: 0;
    box-sizing: border-box;
    font-size: 19px;
    text-align: center;
    background-color: #265c22;
    border: 1px solid #666;
    color: #fff;
}
.modal-offer-wrap input[type="submit"] {
    color: #fff;
    font: 1.5em "Roboto", sans-serif;
    background: #61ae24;
    text-align: center;
    height: 32px;

    width: 190px;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.53);
    -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.53);
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.53);
    border: solid 1px #c2c2c2;
    -moz-border-radius: 13px;
    -webkit-border-radius: 13px;
    border-radius: 13px;
    outline: none;
}
.modal-offer-wrap input[type="submit"].submit-on:hover {
    background: #32742c !important;
}
.modal-offer-wrap input[type="submit"].submit-off {
    background-color: #EC0355;
    width: 270px;
}
.modal-offer-wrap input[type="submit"].submit-off:hover {
    background-color: #AD003D;
}
.clear{
    clear: both;
}


.modal-offer-wrap input[type="checkbox"] {
    display:none;            
}
.modal-offer-wrap input[type="checkbox"] + label {
    font: 18px bold;
    color: #444;
    cursor: pointer;
    line-height: 30px;
    font-family: Roboto;
    font-weight: lighter;
    color: #fff;
    float: left;
    text-align: center;
    border: 1px solid #DCDCDC;
}
.modal-offer-wrap input[type="checkbox"] + label:hover::before {
    background-color: #00a1cb !important;
}

.modal-offer-wrap input[type="checkbox"] + label::before {
    display: inline-block;
    height: 30px;
    width: 40px;
    background-color: rgb(36, 174, 47);
}


.modal-offer-wrap input[type="checkbox"]#mon + label::before {
    content: "ПН";
}
.modal-offer-wrap input[type="checkbox"]#tue + label::before {
    content: "ВТ";
}
.modal-offer-wrap input[type="checkbox"]#wed + label::before {
    content: "СР";
}
.modal-offer-wrap input[type="checkbox"]#thu + label::before {
    content: "ЧТ";
}
.modal-offer-wrap input[type="checkbox"]#fri + label::before {
    content: "ПТ";
}
.modal-offer-wrap input[type="checkbox"]#sat + label::before {
    content: "СБ";
}
.modal-offer-wrap input[type="checkbox"]#sun + label::before {
    content: "ВС";
}


.modal-offer-wrap input[type="checkbox"]:checked + label::before {
    background-color: rgb(36, 174, 47);
}
.modal-offer-wrap input[type="checkbox"]:checked + label {
    color: #fff;
}
.modal-offer-wrap input[type="checkbox"]:not(checked) + label::before {
    background-color: #fff;
}
.modal-offer-wrap input[type="checkbox"]:not(checked) + label {
    color: #000;
}
.modal-offer-wrap input[type="checkbox"]:disabled + label::before {
    background-color: #fff;
}
.modal-offer-wrap input[type="checkbox"]:checked:disabled + label::before {
    background-color: #fff;
}




    
</style>