<?php yii::app()->functions->sessionInit();?> 

<?php //if (!isset($_SESSION[KARENDERIA]['login']) && $_SESSION[KARENDERIA]['login']!=1 ):?>
<?php if (!isset($_SESSION[KARENDERIA]['login']) ):?>
<div class="login_option_wrap">
  <p><?php echo Yii::t('default',"Already have account?")?> Click <a href="javascript:;"  data-toggle="modal" data-target=".pop_login" ><?php echo Yii::t('default',"here")?></a> <?php echo Yii::t('default',"to sign In")?> </p>
</div> <!--END login_option_wrap-->
<?php endif;?>

<?php $paypal_enabled=yii::app()->functions->getOption('paypal_enabled');?>

<form id="frm_delivery" class="form"  method="GET">

<?php //if (!isset($_SESSION[KARENDERIA]['login']) && $_SESSION[KARENDERIA]['login']!=1 ):?>
<?php if (!isset($_SESSION[KARENDERIA]['login']) ):?>
<input type="hidden" name="action" value="formDelivery">
<input type="hidden" name="trans_type" id="trans_type" value="delivery">
<input type="hidden" id="payment_enabled" name="payment_enabled" value="<?php echo $paypal_enabled?>">
<h2><?php echo Yii::t('default',"Information")?></h2>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Name")?>*</span>
<input type="text"  name="fullname" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Name")?>">
</div>

<!--<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Phone")?></span>
<input type="text"  name="phone" class="form-control" placeholder="<?php echo Yii::t('default',"Phone number")?>">
</div>-->

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Phone/ Mobile")?></span>
<input type="text"  name="mobile" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Phone/ Mobile")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Email")?>*</span>
<input type="text"  name="email" data-validation="email" class="form-control" placeholder="<?php echo Yii::t('default',"Email Address")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Password")?>*</span>
<input type="password" name="password" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Password")?>">
</div>
<?php endif;?>

<?php $address_info='';?>
<?php if (!isset($_SESSION[KARENDERIA]['login'])):?>
<h2><?php echo Yii::t("default","Delivery Information")?></h2>
<?php else :?>

<input type="hidden" name="action" value="formDeliveryUpdate">
<input type="hidden" id="payment_enabled" name="payment_enabled" value="<?php echo $paypal_enabled?>">
<h2><?php echo Yii::t("default","Please Verify your Delivery Information")?></h2>
<?php $address_info=$_SESSION[KARENDERIA]['user_info']?>

<?php endif;?>

<?php 
if (!isset($address_info['delivery_address'])){
	$address_info['delivery_address']='';
}
if (!isset($address_info['location_name'])){
	$address_info['location_name']='';
}
if (!isset($address_info['delivery_instruction'])){
	$address_info['delivery_instruction']='';
}
?>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Delivery Date")?></span>

<div class="col-md-3">
<?php echo CHtml::radioButton('delivery_asap',true,array('value'=>2))?>
<?php echo Yii::t("default","Today ASAP")?>
</div>

<div class="col-md-3">
<?php echo CHtml::radioButton('delivery_asap',false,array('value'=>1))?>
<?php echo Yii::t("default","Choose Another Date")?>
</div>

<div class="col-md-5">

<input type="text" value=""  name="delivery_date" class="delivery_date j_date2 form-control" style="width:120px;" placeholder="<?php echo Yii::t("default","Date")?>" >

<input type="text" value=""  name="delivery_time" class="delivery_date timepick form-control"  style="width:120px;" placeholder="<?php echo Yii::t("default","Time")?>" >
</div>

</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Delivery Address")?> *</span>
<textarea name="delivery_address" class="form-control" cols="5" rows="2" placeholder="<?php echo Yii::t('default',"Delivery Address")?>" data-validation="required"><?php echo $address_info['delivery_address']?></textarea>
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Delivery instructions")?></span>
<textarea name="delivery_instruction" class="form-control" cols="5" rows="2" placeholder="<?php echo Yii::t('default',"Delivery instructions")?>"><?php echo $address_info['delivery_instruction']?></textarea>
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Location Name")?></span>
<input type="text" value="<?php echo $address_info['location_name']?>"  name="location_name" class="form-control" placeholder="<?php echo Yii::t('default',"Location Name eg. house, office")?>">
</div>


<input type="button" onclick="window.history.back();" class="btn_grey mybtn" value="<?php echo Yii::t('default',"Back")?>"></input>
<input type="submit" id="submit" value="<?php echo Yii::t('default',"Next")?>"  class="mybtn buttonorange">

</form>