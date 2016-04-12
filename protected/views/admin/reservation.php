
<h2><?php echo Yii::t("default","Reservation Settings")?></h2>

<form id="frm_receipt" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="action" value="reservationSettings">

<div class="input_block">
<label><?php echo Yii::t('default',"Send Reservation to")?>:</label>
<?php echo CHtml::textField("reservation_to_email",yii::app()->functions->getOption('reservation_to_email'),
array(
'placeholder'=>Yii::t("default","Email Address")
))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Subject")?>:</label>
<?php echo CHtml::textField("reservation_subject",yii::app()->functions->getOption('reservation_subject'),
array(
'placeholder'=>Yii::t("default","Receipt Subject")
))?>
</div>


<div class="input_block">
<label><?php echo Yii::t("default","Reservation Message")?></label>
</div>
<textarea style="height:100px;" name="reservation_description" id="reservation_description" data-uk-htmleditor="{mode:'split', maxsplitsize:500}"  ><?php echo yii::app()->functions->getOption('reservation_description');?></textarea>
<div style="height:20px;"></div>



<input type="submit" class="uk-button uk-button-success" value="<?php echo Yii::t('default',"Submit")?>">

</form>