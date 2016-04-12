<form id="frm_settings" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="action" value="contactSettings">

<div class="input_block">
<label><?php echo Yii::t('default',"Contact Content")?></label>
<?php echo CHtml::textArea("contact_content",yii::app()->functions->getOption('contact_content'),
array(
'id'=>'contact_content'
))?>
</div>

<h4><?php echo Yii::t('default',"Map")?></h4>

<div class="input_block">
<label><?php echo Yii::t('default',"Display Google Map")?></label>
<?php echo CHtml::checkBox('contact_map',yii::app()->functions->getOption('contact_map'),array(
'class'=>"icheck"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Latitude")?></label>
<?php echo CHtml::textField("map_latitude",yii::app()->functions->getOption('map_latitude'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Longitude")?></label>
<?php echo CHtml::textField("map_longitude",yii::app()->functions->getOption('map_longitude'))?>
</div>


<?php 
$fields=yii::app()->functions->getOption('contact_field');
if (!empty($fields)){
	$fields=json_decode($fields);
}
?>
<div class="input_block contact_fields">
<label><?php echo Yii::t('default',"Contact Fields")?></label>
<ul>
 <li><span><?php echo Yii::t('default',"Name")?>:</span><?php echo CHtml::checkBox('contact_field[]',
 in_array('name',(array)$fields)?true:false,array('value'=>'name','class'=>"icheck"))?></li>
 
 <li><span><?php echo Yii::t('default',"Email")?>:</span><?php echo CHtml::checkBox('contact_field[]',
 in_array('email',(array)$fields)?true:false,array('value'=>'email','class'=>"icheck"))?></li>
 
 <li><span><?php echo Yii::t('default',"Phone")?>:</span><?php echo CHtml::checkBox('contact_field[]',
 in_array('phone',(array)$fields)?true:false,array('value'=>'phone','class'=>"icheck"))?></li>
 
 <li><span><?php echo Yii::t('default',"Country")?>:</span><?php echo CHtml::checkBox('contact_field[]',
 in_array('country',(array)$fields)?true:false,array('value'=>'country','class'=>"icheck"))?></li>
 
 <li><span><?php echo Yii::t('default',"Message")?>:</span><?php echo CHtml::checkBox('contact_field[]',
 in_array('message',(array)$fields)?true:false,array('value'=>'message','class'=>"icheck"))?></li>
</ul>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Send To")?>:</label>
<?php echo CHtml::textField("contact_email_receiver",yii::app()->functions->getOption('contact_email_receiver'),
array(
'placeholder'=>Yii::t("default","Email address")
))?>
<span><?php echo Yii::t('default',"Email address that will receive the contact form")?>.</span>
</div>

<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success">

</form>