<?php 
$email_engine=Yii::app()->functions->getOption("email_engine");
$sme_smtp_encryption=Yii::app()->functions->getOption("sme_smtp_encryption");
$sme_smtp_authentication=Yii::app()->functions->getOption("sme_smtp_authentication");
?>

<form id="frm_smtp" method="POST" onsubmit="return false;" class="uk-form uk-form-horizontal">

<p><?php echo Yii::t("default","Note: For SMTP Settings make sure you had fill the sender in receipt settings.")?></p>

<input type="hidden" name="action" value="smtpSaveSettings">
<h2><?php echo Yii::t("default","Email")?></h2>
<div class="input_block">
<li><input class="icheck" <?php echo $email_engine==1?"checked":"";?> name="email_engine" type="radio" value="1"> <?php echo Yii::t("default","USE PHP mail functions")?></li>
<li><input class="icheck" <?php echo $email_engine==2?"checked":"";?> name="email_engine" type="radio" value="2"> <?php echo Yii::t("default","USE SMTP")?></li>
</div>


<h2><?php echo Yii::t("default","SMTP Settings")?></h2>

<div class="input_block">
<label><?php echo Yii::t("default","SMSTP HOST")?></label>
<?php echo CHtml::textField('smtp_host',Yii::app()->functions->getOption("smtp_host"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t("default","SMTP PORT")?></label>
<?php echo CHtml::textField('sme_smtp_port',Yii::app()->functions->getOption("sme_smtp_port"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t("default","Encryption")?></label>
<li><?php echo CHtml::radioButton('sme_smtp_encryption',
$sme_smtp_encryption=="no"?true:false,array('value'=>'no','class'=>"icheck"))?> <?php echo Yii::t("default","No encryption")?> </li>
<li><?php echo CHtml::radioButton('sme_smtp_encryption',
$sme_smtp_encryption=="ssl"?true:false,array('value'=>'ssl','class'=>"icheck"))?> <?php echo Yii::t("default","Use SSL encryption")?> </li>
<li><?php echo CHtml::radioButton('sme_smtp_encryption',
$sme_smtp_encryption=="tls"?true:false,array('value'=>'tls','class'=>"icheck"))?> <?php echo Yii::t("default","Use TLS encryption")?> </li>
</div>

<div class="input_block">
<label><?php echo Yii::t("default","Authentication")?></label>

<li><?php echo CHtml::radioButton('sme_smtp_authentication',
$sme_smtp_authentication==1?true:false,array('value'=>1,'class'=>"icheck"))?>  <?php echo Yii::t("default","No: Do not use SMTP Authentication")?></li>
<li><?php echo CHtml::radioButton('sme_smtp_authentication',
$sme_smtp_authentication==2?true:false,array('value'=>2,'class'=>"icheck"))?> <?php echo Yii::t("default","Yes: Use SMTP Authentication")?></li>

</div>

<div class="input_block">
<label><?php echo Yii::t("default","Username")?></label>
<?php echo CHtml::textField('sme_smtp_username',Yii::app()->functions->getOption("sme_smtp_username"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t("default","Password")?></label>
<?php echo CHtml::textField('sme_smtp_password',Yii::app()->functions->getOption("sme_smtp_password"))?>
</div>

<div class="input_block">
<input type="submit" value="<?php echo Yii::t("default","Submit")?>" class="btn uk-button uk-button-success">
<a href="javascript:;" class="email_test uk-button"><?php echo Yii::t("default","Send Me a Email Test")?></a>
</div>

</form>