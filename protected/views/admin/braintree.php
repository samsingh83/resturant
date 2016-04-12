
<form id="frm_settings" method="POST"  class="uk-form uk-form-horizontal">
<input type="hidden" name="action" value="braintreeSettings">

<h2 class="uk-h2"><?php echo t("Braintree")?></h2>

<div class="input_block">
<label><?php echo Yii::t("default","Enabled Creditcard")?></label>
<?php 
$braintree_enabled=yii::app()->functions->getOption('braintree_enabled');
$chk1=FALSE;$chk2=FALSE;
if ($braintree_enabled==1){
	$chk1=TRUE;
}
if ($braintree_enabled==2){
	$chk2=TRUE;
}
?>
<?php echo CHtml::radioButton('braintree_enabled',$chk1,array('value'=>'1','class'=>"icheck"))?> <?php echo Yii::t('default',"Yes")?>
 <?php echo CHtml::radioButton('braintree_enabled',$chk2,array('value'=>'2','class'=>"icheck"))?> <?php echo Yii::t('default',"No")?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Mode")?></label>
<?php 
$braintree_mode=yii::app()->functions->getOption('braintree_mode');
$chk1=FALSE;$chk2=FALSE;
if ($braintree_mode=="sandbox"){
	$chk1=TRUE;
}
if ($braintree_mode=="live"){
	$chk2=TRUE;
}
?>
<?php echo CHtml::radioButton('braintree_mode',$chk1,array('value'=>'sandbox','class'=>"icheck"))?> <?php echo Yii::t('default',"Sandbox")?> 
<?php echo CHtml::radioButton('braintree_mode',$chk2,array('value'=>'live','class'=>"icheck"))?> <?php echo Yii::t('default',"Live")?>
</div>

<h3><?php echo Yii::t('default',"Sandbox")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Merchant ID")?></label>
<?php echo CHtml::textField('braintree_mtid',yii::app()->functions->getOption('braintree_mtid'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Public Key")?></label>
<?php echo CHtml::textField('braintree_key',yii::app()->functions->getOption('braintree_key'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Private Key")?></label>
<?php echo CHtml::textField('braintree_privatekey',yii::app()->functions->getOption('braintree_privatekey'))?>
</div>


<h3><?php echo Yii::t("default","Live")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Merchant ID")?></label>
<?php echo CHtml::textField('live_braintree_mtid',yii::app()->functions->getOption('live_braintree_mtid'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Public Key")?></label>
<?php echo CHtml::textField('live_braintree_key',yii::app()->functions->getOption('live_braintree_key'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Private Key")?></label>
<?php echo CHtml::textField('live_braintree_privatekey',yii::app()->functions->getOption('live_braintree_privatekey'))?>
</div>


<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success">

</form>