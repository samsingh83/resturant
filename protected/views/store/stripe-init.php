<?php

require_once('stripe/lib/Stripe.php');

$step2=false;
$amount_to_pay=0;
$payment_description=Yii::t("default",'Payment For Food Order');
$merchant_name=yii::app()->functions->getOption("store_name");


$secret_key='';
$publishable_key='';
$error='';

if ($amount_to_pay=getOrderCart("Stripe",$_GET['trans_type'])){	
	$mode=Yii::app()->functions->getOption('admin_stripe_mode');   
	//dump($mode);
	if ( $mode=="Sandbox"){
		$secret_key=Yii::app()->functions->getOption('admin_sanbox_stripe_secret_key');   
		$publishable_key=Yii::app()->functions->getOption('admin_sandbox_stripe_pub_key');   
	} elseif ($mode=="live"){
		$secret_key=Yii::app()->functions->getOption('admin_live_stripe_secret_key');   
		$publishable_key=Yii::app()->functions->getOption('admin_live_stripe_pub_key');   
	}
	
	//dump($secret_key);dump($publishable_key);
	if ( !empty($mode) && !empty($secret_key) && !empty($publishable_key) ){
		
		$amount_to_pay=prettyPrice($amount_to_pay);
		$amount_to_pay=is_numeric($amount_to_pay)?unPrettyPrice($amount_to_pay*100):'';		
		$amount_to_pay=Yii::app()->functions->normalPrettyPrice($amount_to_pay);				
									
		$stripe = array(
	     "secret_key"      => $secret_key,
	     "publishable_key" => $publishable_key
	    );	    
	    Stripe::setApiKey($stripe['secret_key']);
    
	} else $error=Yii::t("default","Stripe payment is not properly configured on merchant portal.");
	
} else $error=Yii::t("default","Amount to pay is empty");

if (isset($_POST)){
	if (is_array($_POST) && count($_POST)>=1){		
		$step2=true;
		$token=isset($_POST['stripeToken'])?$_POST['stripeToken']:'';
		
		try {
			$customer = Stripe_Customer::create(array(
		      'email' => isset($_POST['stripeEmail'])?$_POST['stripeEmail']:'',
		      'card'  => $token
		    ));
		    	           
	        $charge = Stripe_Charge::create(array(
	          'customer' => $customer->id,
	          'amount'   => $amount_to_pay,
	          'currency' => Yii::app()->functions->getCurrencyCodes()
	        ));	        
	        
	        $trans_type='delivery';
			if (isset($_GET['trans_type'])){
				if (!empty($_GET['trans_type'])){
				   $trans_type=$_GET['trans_type'];
				}
			}	        
			
			$AjaxSites=new AjaxSites;
	        $order_id=$AjaxSites->saveOrder(yii::app()->functions->userId(),$trans_type,'stripe');             
	        	        
	        $chargeArray = $charge->__toArray(true);           
	        $db_ext=new DbExt;
	        $params_logs=array(
	          'order_id'=>$order_id,
	          'payment_method'=>"stripe",
	          'json_data'=>json_encode($chargeArray),
	          'date_created'=>date('c'),
	          'ip_address'=>$_SERVER['REMOTE_ADDR']
	        );
	        $db_ext->insertData("{{braintree_trans}}",$params_logs);
	        
	        header('Location: '.Yii::app()->request->baseUrl."/store/receipt/order_id/".$order_id);
	    } catch (Exception $e)   {
	    	$error=$e;
	    }    
	}
}
?>


<div class="main">  
<?php if ( !empty($error)):?>
<p class="uk-text-danger"><?php echo $error;?></p>  
<?php else :?>

<?php if ( $step2==TRUE):?>

<?php else :?>
<h2><?php echo Yii::t("default","Pay using Stripe Payment")?></h2>
<form action="<?php echo Yii::app()->request->baseUrl."/store/stripeinit/?trans_type=".$_GET['trans_type']?>" method="post">
<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
      data-key="<?php echo $stripe['publishable_key']; ?>"
      data-name="<?php echo ucwords($merchant_name);?>"
      data-amount="<?php echo $amount_to_pay;?>" 
      data-currency="<?php echo Yii::app()->functions->getCurrencyCodes();?>"
      data-description="<?php echo ucwords($payment_description);?>">
</script>
</form>
<?php endif;?>

<?php endif;?>
</div>