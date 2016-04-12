

<form id="frm_settings" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="action" value="settings">

<h2><?php echo Yii::t('default',"Store Information")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Store Name")?></label>
<?php echo CHtml::textField('store_name',yii::app()->functions->getOption('store_name') )?>
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Store Logo")?></label>	 	 
  <div  class="uk-button" id="storelogo"><?php echo Yii::t('default',"Browse")?></div>	  
  <DIV  style="display:none;" class="storelogo_chart_status" >
	<div id="percent_bar" class="storelogo_percent_bar"></div>
	<div id="progress_bar" class="storelogo_progress_bar">
	  <div id="status_bar" class="storelogo_status_bar"></div>
	</div>
  </DIV>		  
</div>

<?php 
$logo=yii::app()->functions->getOption('store_logo');
?>
<?php if (!empty($logo)):?>
<div class="input_block">
<?php else :?>
<div class="input_block preview">
<?php endif;?>
<label><?php echo Yii::t('default',"Preview")?></label>
<div class="image_preview">
 <?php if (!empty($logo)):?>
 <input type="hidden" name="photo" value="<?php echo $logo;?>">
 <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$logo;?>?>" alt="" title=""> 
 <p><a href="javascript:rm_preview();">remove Logo</a></p>
 <?php endif;?>
</div>
</div>

<?php 
$disabled_wishlist=Yii::app()->functions->getOption("disabled_wishlist");
$disabled_notes=Yii::app()->functions->getOption("disabled_notes");
$disabled_events=Yii::app()->functions->getOption("disabled_events");
$disabled_cashondelivery=Yii::app()->functions->getOption("disabled_cashondelivery");
$disabled_voucher=Yii::app()->functions->getOption("disabled_voucher");
$disabled_offlinepayment=Yii::app()->functions->getOption("disabled_offlinepayment");
$disabled_reservation=Yii::app()->functions->getOption("disabled_reservation");
$store_hours_format=Yii::app()->functions->getOption("store_hours_format");
$enabled_preorder=Yii::app()->functions->getOption("enabled_preorder");
?>
<h2><?php echo Yii::t('default',"Front Settings")?></h2>

<div class="input_block">
<label><?php echo Yii::t('default',"When purchase redirect user to receipt?")?></label>
<?php
echo CHtml::checkBox('disabled_checkout',
Yii::app()->functions->getOption("disabled_checkout")==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Disabled Wishlist?")?></label>
<?php
echo CHtml::checkBox('disabled_wishlist',
$disabled_wishlist==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Disabled Notes?")?></label>
<?php
echo CHtml::checkBox('disabled_notes',
$disabled_notes==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Disabled Events?")?></label>
<?php
echo CHtml::checkBox('disabled_events',
$disabled_events==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Disabled Voucher?")?></label>
<?php
echo CHtml::checkBox('disabled_voucher',
$disabled_voucher==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Disabled Reservation?")?></label>
<?php
echo CHtml::checkBox('disabled_reservation',
$disabled_reservation==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>


<div class="input_block">
<label><?php echo Yii::t('default',"Disabled Cash<br/>On Delivery?")?></label>
<?php
echo CHtml::checkBox('disabled_cashondelivery',
$disabled_cashondelivery==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Disabled Card Payment?")?></label>
<?php
echo CHtml::checkBox('disabled_offlinepayment',
$disabled_offlinepayment==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Enabled PreOrder Verification?")?></label>
<?php
echo CHtml::checkBox('enabled_preorder',
$enabled_preorder==1?true:false
,array(
'value'=>1,
'class'=>"icheck"
));
?>
</div>

<?php 
$allowed_ordering=Yii::app()->functions->getOption("allowed_ordering");
?>
<h2><?php echo Yii::t('default',"Store Ordering")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Allowed Ordering")?></label>
<ul>
<li><input class="icheck" <?php echo $allowed_ordering==1?"checked":"";?> name="allowed_ordering" type="radio" value="1"> <?php echo Yii::t("default","Yes")." ".Yii::t("default","(default)")?></li>
<li><input class="icheck" <?php echo $allowed_ordering==2?"checked":"";?> name="allowed_ordering" type="radio" value="2"> <?php echo Yii::t("default","No")?></li>
<div class="clear"></div>
</ul>
</div>

<h2><?php echo Yii::t('default',"Store Currency")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Currency Code")?></label>
<?php echo CHtml::dropDownList('currency_code',yii::app()->functions->getOption('currency_code'),
(array)Yii::app()->functions->currencyList()
)?>
</div>

<h2><?php echo Yii::t('default',"Price Format")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Decimal Places")?></label>
<?php echo CHtml::dropDownList('decimal_places',yii::app()->functions->getOption('decimal_places'),
(array)Yii::app()->functions->decimalPlacesList()
)?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Use 1000 Separators(,)")?></label>
<?php echo CHtml::checkBox('decimal_separators',yii::app()->functions->getOption('decimal_separators'),array(
'value'=>1,
'class'=>"icheck"
)) ?>
</div>

<?php $country_list=require_once "CountryCode.php";?>
<h2><?php echo Yii::t('default',"Store Address")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Country")?></label>
<?php echo CHtml::dropDownList('country_code',yii::app()->functions->getOption('country_code'),$country_list)?>
<span>Note: Country is required in order to get the delivery distance.</span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Address")?></label>
<?php echo CHtml::textField('address',yii::app()->functions->getOption('address') )?>
<span>Note: Address is required in order to get the delivery distance.</span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Contact Phone Number")?></label>
<?php echo CHtml::textField('phone_number',yii::app()->functions->getOption('phone_number'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Contact Email")?></label>
<?php echo CHtml::textField('contact_email',yii::app()->functions->getOption('contact_email'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Time Picker Format")?></label>
<?php 
echo CHtml::dropDownList('store_hours_format',
$store_hours_format
,array(
 1=>Yii::t("default","12 hours"),
 2=>Yii::t("default","24 hours")
));
?>
</div>

<h2><?php echo Yii::t('default',"Minimum Order")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Amount")?></label>
<?php echo CHtml::textField('minimum_order',yii::app()->functions->getOption('minimum_order'),
array('class'=>'small_input numeric_only'))?>
<span><?php echo Yii::t("default","Minumum purchase amount")?>.</span>
</div>


<h2><?php echo Yii::t('default',"Tax/Delivery Charges")?></h2>

<div class="input_block">
<label><?php echo Yii::t('default',"Tax")?></label>
<?php echo CHtml::textField('tax_amount',yii::app()->functions->getOption('tax_amount'),
array('data-validation-allowing'=>'float,negative','data-validation'=>'number','class'=>'small_input numeric_only'))?>
<b>%</b>
</div>


<div class="input_block">
<label><?php echo Yii::t('default',"Delivery charges")?></label>
<?php echo CHtml::textField('delivery_charges',yii::app()->functions->getOption('delivery_charges'),
array('data-validation-allowing'=>'float,negative','data-validation'=>'number','class'=>'small_input numeric_only'))?>
<b><?php echo yii::app()->functions->getCurrencyCode()?></b>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Convenience Charge")?></label>
<?php echo CHtml::textField('convenience_charge',yii::app()->functions->getOption('convenience_charge'),
array('data-validation-allowing'=>'float,negative','data-validation'=>'','class'=>'small_input numeric_only'))?>
<b><?php echo yii::app()->functions->getCurrencyCode()?></b>
</div>

<h2><?php echo Yii::t('default',"Delivery Distance")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Delivery Distance")?></label>
<?php echo CHtml::textField('delivery_distance',yii::app()->functions->getOption('delivery_distance'),
array('class'=>'small_input numeric_only'))?>
<span><?php echo Yii::t('default',"km (leave empty to not check the delivery distance)")?></span>
</div>

<?php 
$voucher_enabled=Yii::app()->functions->getOption("voucher_enabled");
?>
<h2><?php echo Yii::t('default',"Voucher (discount)")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Enabled Voucher Code")?></label>
<ul>
<li><input class="icheck" <?php echo $voucher_enabled==1?"checked":"";?> name="voucher_enabled" type="radio" value="1"> <?php echo Yii::t("default","Yes")?></li>
<li><input class="icheck" <?php echo $voucher_enabled==2?"checked":"";?> name="voucher_enabled" type="radio" value="2"> <?php echo Yii::t("default","No")?></li>
<div class="clear"></div>
</ul>
</div>

<h2><?php echo Yii::t('default',"Receipt")?></h2>
<div class="input_block">
<label><?php echo Yii::t('default',"Message")?></label>
<?php echo CHtml::textArea('receipt_msg',yii::app()->functions->getOption('receipt_msg'))?>
</div>


<h2><?php echo Yii::t('default',"Notification")?></h2>

<div class="input_block">
<label><?php echo Yii::t('default',"Email address")?>:</label>
<?php echo CHtml::textField('email_address_notify',yii::app()->functions->getOption('email_address_notify'))?>
<span><?php echo Yii::t('default',"Email address of the person who will receive if there is new order")?>.</span>
</div>


<h2><?php echo Yii::t("default","CheckOut Type")?></h2>

<?php
$checkout_type1=Yii::app()->functions->getOption('checkout_type_1');
$checkout_type2=Yii::app()->functions->getOption('checkout_type_2');
?>

<div class="input_block">
<ul>
<li style="margin-bottom:10px;"><input class="icheck" <?php echo $checkout_type1==1?"checked":"";?> name="checkout_type_1" type="checkbox" value="1"> <?php echo Yii::t("default","Delivery")?></li>
<li><input class="icheck" <?php echo $checkout_type2==2?"checked":"";?> name="checkout_type_2" type="checkbox" value="2"> <?php echo Yii::t("default","CarryOut")?></li>
<div class="clear"></div>
</ul>
</div>


<h2><?php echo Yii::t('default',"Footer Store Name")?></h2>
<div class="input_block">
<label><?php echo Yii::t("default","Name")?></label>
<?php echo CHtml::textField('footer_store_name',Yii::app()->functions->getOption("footer_store_name") )?>
<span>Eg. Karinderia &copy;  2014</span>
</div>

<h2><?php echo Yii::t('default',"Store Hours")?></h2>
<!--<div class="input_block">
<label><?php echo Yii::t('default',"Store Hours Open")?>:</label>
<?php echo CHtml::textField('stores_open_start',yii::app()->functions->getOption('stores_open_start'),
array('class'=>'timepick small_input'))?>
<b><?php echo Yii::t('default',"To")?></b>
<?php echo CHtml::textField('stores_open_end',yii::app()->functions->getOption('stores_open_end'),
array('class'=>'timepick small_input'))?>
</div>-->

<?php 
$stores_open_am_start=yii::app()->functions->getOption('stores_open_am_start');
$stores_open_am_end=yii::app()->functions->getOption('stores_open_am_end');
$text_day=yii::app()->functions->getOption('text_day');
if (!empty($stores_open_am_start)){
	$stores_open_am_start=(array)json_decode($stores_open_am_start);
}
if (!empty($stores_open_am_end)){
	$stores_open_am_end=(array)json_decode($stores_open_am_end);
}
if (!empty($text_day)){
	$text_day=(array)json_decode($text_day);
}

$stores_open_pm_start=yii::app()->functions->getOption('stores_open_pm_start');
$stores_open_pm_end=yii::app()->functions->getOption('stores_open_pm_end');
if (!empty($stores_open_pm_start)){
	$stores_open_pm_start=(array)json_decode($stores_open_pm_start);
}
if (!empty($stores_open_pm_end)){
	$stores_open_pm_end=(array)json_decode($stores_open_pm_end);
}
?>

<div class="input_block stores_open_wrap">
<label><?php echo Yii::t('default',"Store days(s) Open")?>:</label>
<?php foreach (yii::app()->functions->getDays() as $key => $days):?>
<?php 
      $chk=FALSE;
      if ($days_selected=yii::app()->functions->getOption('stores_open_day')){
      	  $days_selected=json_decode($days_selected);
      }      
      if (in_array($key,(array)$days_selected)){
      	  $chk=TRUE;
      }
?>
<li>
<div class="day_wrap">
<?php echo CHtml::checkBox("stores_open_day[]",$chk,array('value'=>$key,'class'=>"icheck"))?> <?php echo $days;?>
</div>

<div class="time_wrap">
<?php echo CHtml::textField("stores_open_am_start[$key]",
array_key_exists($key,(array)$stores_open_am_start)? $stores_open_am_start[$key] : "" ,
array('class'=>'timepick small_input'))?>
</div>  

<div class="time_wrap">
<b><?php echo Yii::t("default","To")?></b>
</div>

<div class="time_wrap">
<?php echo CHtml::textField("stores_open_am_end[$key]",
array_key_exists($key,(array)$stores_open_am_end)? $stores_open_am_end[$key] : "" ,
array('class'=>'timepick small_input'))?>
</div>  

<div class="time_wrap">
<b> / </b>
</div>


<div class="time_wrap">
<?php echo CHtml::textField("stores_open_pm_start[$key]",
array_key_exists($key,(array)$stores_open_pm_start)? $stores_open_pm_start[$key] : "" ,
array('class'=>'timepick small_input'))?>
</div>  

<div class="time_wrap">
<b><?php echo Yii::t("default","To")?></b>
</div>

<div class="time_wrap">
<?php echo CHtml::textField("stores_open_pm_end[$key]",
array_key_exists($key,(array)$stores_open_pm_end)? $stores_open_pm_end[$key] : "" ,
array('class'=>'timepick small_input'))?>
</div>  

<div class="time_wrap">
<?php echo CHtml::textField("text_day[$key]",
array_key_exists($key,(array)$text_day)? $text_day[$key] : "" ,
array(
'placeholder'=>Yii::t("default","Custom text")
))?>
</div>  

 <div class="clear"></div>
</li>

<?php endforeach;?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Custom Store<br/>Opening")?>:</label>
<?php echo CHtml::textArea('custom_opening_msg',yii::app()->functions->getOption('custom_opening_msg'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Close Message")?>:</label>
<?php echo CHtml::textArea('close_msg',yii::app()->functions->getOption('close_msg'))?>
</div>

<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success">

</form>