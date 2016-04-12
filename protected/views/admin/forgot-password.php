<form id="frm_receipt" method="POST"  class="uk-form uk-form-horizontal" >
<input type="hidden" name="action" value="forgotPassTPL">

<div class="input_block">
<label><?php echo Yii::t('default',"Sender")?>:</label>
<?php echo CHtml::textField("forgot_sender",yii::app()->functions->getOption('forgot_sender'),
array(
'placeholder'=>Yii::t("default","Email address"),
'data-validation'=>'required'
))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Subject")?>:</label>
<?php echo CHtml::textField("forgot_subject",yii::app()->functions->getOption('forgot_subject'),
array(
'placeholder'=>Yii::t("default","Subject"),
'data-validation'=>'required'
))?>
</div>

<?php 
$content=yii::app()->functions->getOption('forgot_tpl');
if (empty($content)){
	$content="Dear {customer-name},";
	$content.="\t\n\t\n  Click on the link below to change your password.";
	$content.="\t\n\t\n {reset-password-link}";
	$content.="\t\n\t\n Thank you.";
}
?>

<div class="input_block">
<label><?php echo Yii::t('default',"Email Content")?></label>
<?php echo CHtml::textArea("forgot_tpl",$content,
array(
'id'=>'contact_content'
))?>
</div>

<div class="right">
<p><b><?php echo Yii::t('default',"Available Tags")?></b></p>
<p><?php echo Yii::t('default',"{customer-name} customer name")?></p>
<p><?php echo Yii::t('default',"{reset-password-link} the reset password link")?></p>
</div>
<div class="clear"></div>

<input type="submit" class="uk-button uk-button-success" value="<?php echo Yii::t('default',"Submit")?>">

</form>