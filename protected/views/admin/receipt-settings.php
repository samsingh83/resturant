<form id="frm_receipt" method="POST"  class="uk-form uk-form-horizontal" >
<input type="hidden" name="action" value="receiptSettings">

<div class="input_block">
<label><?php echo Yii::t('default',"Sender")?>:</label>
<?php echo CHtml::textField("receipt_from_email",yii::app()->functions->getOption('receipt_from_email'),
array(
'placeholder'=>Yii::t("default","Email address")
))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Subject")?>:</label>
<?php echo CHtml::textField("receipt_subject",yii::app()->functions->getOption('receipt_subject'),
array(
'placeholder'=>Yii::t("default","Receipt Subject")
))?>
</div>

<?php 
$content=yii::app()->functions->getOption('receipt_content');
if (empty($content)){
	$content="Dear {customer-name},";
	$content.="\t\n\t\n  Thank you for shopping at Karinderia. We hope you enjoy your new purchase! Your order number is {receipt-number}. We have included your order receipt and delivery details below:";
	$content.="\t\n\t\n {receipt}";
	$content.="\t\n\t\n Kind Regards";
}
?>

<div class="input_block">
<label><?php echo Yii::t('default',"Email Content")?></label>
<?php echo CHtml::textArea("receipt_content",$content,
array(
'id'=>'contact_content'
))?>
</div>

<div class="right">
<p><b><?php echo Yii::t('default',"Available Tags")?></b></p>
<p><?php echo Yii::t('default',"{customer-name} customer name")?></p>
<p><?php echo Yii::t('default',"{receipt-number} receipt/Refference number")?></p>
<p><?php echo Yii::t('default',"{receipt} Printed Receipt")?></p>
</div>
<div class="clear"></div>

<input type="submit" class="uk-button uk-button-success" value="<?php echo Yii::t('default',"Submit")?>" >

</form>