
<?
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div id="modal-feedback" class="white-popup-block mfp-hide">
    <div class="modal-feedback-inner">
    
    <a href="#" class="mfp-close"></a>
        <h2>Обратная связь</h2>
        <div class="towns">
            <?php $form = ActiveForm::begin([
                'id' => 'feedback-form', 
                'action' => ['user/feedback'],
                'fieldConfig' => [
                    'template' => '<div class="feedInput">{input}{error}</div>'
                ],
            ]);?>
                <?= $form->field($Feedback, 'subject')->textInput(['placeholder' => $Feedback->getAttributeLabel('subject')]) ?>
                <?= $form->field($Feedback, 'body')->textarea(['placeholder' => $Feedback->getAttributeLabel('body')])?>
                <input type="submit" class="choose" value="Отправить">
            <?php ActiveForm::end(); ?>
        </div><!-- end towns -->
    </div><!-- end modal-inner -->
</div> 