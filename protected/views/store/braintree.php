<?php
$braintree_mode=Yii::app()->functions->getOption("braintree_mode");
$environment='';
if ( $braintree_mode=="sandbox"){
	$environment="sandbox";
	$braintree_mtid=Yii::app()->functions->getOption("braintree_mtid");
	$braintree_key=Yii::app()->functions->getOption("braintree_key");
	$braintree_privatekey=Yii::app()->functions->getOption("braintree_privatekey");
} else {
	$environment="production";
	$braintree_mtid=Yii::app()->functions->getOption("live_braintree_mtid");
	$braintree_key=Yii::app()->functions->getOption("live_braintree_key");
	$braintree_privatekey=Yii::app()->functions->getOption("live_braintree_privatekey");
}

$path=Yii::getPathOfAlias('webroot')."/braintree";
require_once $path."/connect.php";

$customer_id=yii::app()->functions->userId();

if (!is_numeric($customer_id)){
	$error=Yii::t("default","ERROR: Sorry but your session has expired try to login.");	
} else {

	try {		
	   	$client_search_resp = Braintree_Customer::find($customer_id);   	   
	} catch (Exception $e){	
		$client_info=Yii::app()->functions->getClientInfo($customer_id);		
		//dump("create client");
		$client_resp = Braintree_Customer::create(array(
	       'id' => $customer_id,
	       'firstName' =>$client_info[0]['fullname']
	    ));    
	    if ( $client_resp->success==1){    	
	    } else {
	    	$error=Yii::t("default","ERROR:" . " ".$client_resp->message);    
	    	return ;
	    }
	}
	
	try {		
	   $clientToken = Braintree_ClientToken::generate(array('customerId'=>$customer_id));	   
	} catch (Exception $e){
		$error=$e;
	}
}

if ( !empty($error)){
	echo $error;
} else {
	echo CHtml::hiddenField('clikent_token',$clientToken);
}
echo CHtml::hiddenField('trans_type',isset($_GET['trans_type'])?$_GET['trans_type']:'delivery');
?>

<!--<div id="paypal-button"></div>--><!--
<form id="braincheckout">
  <input data-braintree-name="number" value="4111111111111111">
  <input data-braintree-name="expiration_date" value="10/20">
  <input type="submit" id="submit" value="Pay">
  <div id="paypal-button"></div>
</form>-->

<?php if ( empty($error)):?>
<!--<form id="brain-checkout">
<div id="container"></div>
<input type="submit" id="brain-submit" value="Pay" class="uk-button uk-button-success">
</form>-->

<h1><?php echo Yii::t("default","Credit Card")?></h1>

<form id="brain-checkout" onsubmit="return false;" class="form">
<!--<input data-braintree-name="number" id="number" value="4111111111111111" data-validation="required">
<input data-braintree-name="expiration_date" id="expiration_date" value="10/20" data-validation="required">
<input type="submit" id="submit" value="Pay">-->

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t("default","Card Holder Name")?>*</span>
<input data-braintree-name="cardholder_name" type="text"  name="cardholder_name" id="cardholder_name" data-validation="required" class="form-control" >
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t("default","Card Number")?>*</span>
<input data-braintree-name="number" type="text"  name="number" id="number" data-validation="required" class="form-control" maxlength="19" >
</div>

<div class="row">
<div class="col-sm-5" >
	<div class="input-group">
	<span class="input-group-addon"><?php echo Yii::t("default","Expiration Month")?>*</span>
	<?php 
	echo CHtml::dropDownList('expiration_month','',
	Yii::app()->functions->ccExpirationMonth()
	,array(
	  'data-braintree-name'=>"expiration_month",
	  'class'=>"form-control"
	));
	?>
	</div>
</div>
<div class="col-sm-5" >
	<div class="input-group">
	<span class="input-group-addon"><?php echo Yii::t("default","Expiration Year")?>*</span>
	<?php 
	echo CHtml::dropDownList('expiration_year','',
	Yii::app()->functions->ccExpirationYear()
	,array(
	  'data-braintree-name'=>"expiration_year",
	  'class'=>"form-control"
	));
	?>
	</div>
</div>
</div>


<div class="btn-group">
<input type="submit" id="brain-submit" value="Pay" class="btn btn-success">
</div>

</form>
<?php endif;?>
