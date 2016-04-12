
<form id="frm_settings" method="POST" class="uk-form uk-form-horizontal
" >
<input type="hidden" name="action" value="paypalSettings">

<div class="input_block">
<label><?php echo Yii::t("default","Enabled Paypal")?></label>
<?php 
$paypal_enabled=yii::app()->functions->getOption('paypal_enabled');
$chk1=FALSE;$chk2=FALSE;
if ($paypal_enabled==1){
	$chk1=TRUE;
}
if ($paypal_enabled==2){
	$chk2=TRUE;
}
?>
<?php echo CHtml::radioButton('paypal_enabled',$chk1,array('value'=>'1','class'=>"icheck"))?> <?php echo Yii::t('default',"Yes")?>
 <?php echo CHtml::radioButton('paypal_enabled',$chk2,array('value'=>'2','class'=>"icheck"))?> <?php echo Yii::t('default',"No")?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Mode")?></label>
<?php 
$paypal_mode=yii::app()->functions->getOption('paypal_mode');
$chk1=FALSE;$chk2=FALSE;
if ($paypal_mode=="sandbox"){
	$chk1=TRUE;
}
if ($paypal_mode=="live"){
	$chk2=TRUE;
}
?>
<?php echo CHtml::radioButton('paypal_mode',$chk1,array('value'=>'sandbox','class'=>"icheck"))?> <?php echo Yii::t('default',"Sandbox")?> 
<?php echo CHtml::radioButton('paypal_mode',$chk2,array('value'=>'live','class'=>"icheck"))?> <?php echo Yii::t('default',"Live")?>
</div>

<h3><?php echo Yii::t('default',"Sandbox")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Paypal User")?></label>
<?php echo CHtml::textField('sanbox_paypa_user',yii::app()->functions->getOption('sanbox_paypa_user'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Paypal Password")?></label>
<?php echo CHtml::textField('sanbox_paypa_pass',yii::app()->functions->getOption('sanbox_paypa_pass'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Paypal Signature")?></label>
<?php echo CHtml::textField('sanbox_paypa_signature',yii::app()->functions->getOption('sanbox_paypa_signature'))?>
</div>


<h3>Live</h3>
<div class="input_block">
<label>Paypal User</label>
<?php echo CHtml::textField('live_paypa_user',yii::app()->functions->getOption('live_paypa_user'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Paypal Password")?></label>
<?php echo CHtml::textField('live_paypa_pass',yii::app()->functions->getOption('live_paypa_pass'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Paypal Signature")?></label>
<?php echo CHtml::textField('live_paypa_signature',yii::app()->functions->getOption('live_paypa_signature'))?>
</div>


<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success">

</form>