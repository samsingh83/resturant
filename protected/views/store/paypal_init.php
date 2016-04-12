<?php
yii::app()->functions->data="list";
$cooking_ref_desc=yii::app()->functions->getCookingref(); 
$subcategory_list=yii::app()->functions->getSubcategory();  
$subcategory_item=yii::app()->functions->getSubcategoryItemFullDetails(); 
$size=yii::app()->functions->getSize(); 
    	
$total_addon=0;
$discounted_amount=0;
$total_item=0;
$debug=false;
?>
<?php if ( $res=yii::app()->functions->getOrder($_GET['order_id']) ):?>
  <div class="payment_loading_wrap">    
  </div> 
  <?php 
  if ($debug){
      yii::app()->functions->dump($res); 
  }
  $client_info=Yii::app()->functions->getClientInfo($res[0]['client_id']);  
  foreach ($res as $item){
  	  $item['item_price']=str_replace(",","",$item['item_price']);
  	  $amount=$item['item_price']*$item['qty'];
	  $total_item=$total_item+$amount;	   
	  $food_item_discount=0;
	  if ($food_item=yii::app()->functions->getFoodItemDetails($item['item_id'])){
     	  if (is_numeric($food_item[0]['discount'])){
     	     $food_item[0]['discount']=str_replace(",","",$food_item[0]['discount']);
     	     $food_item_discount=$food_item[0]['discount'];	
     	     $total_item=$total_item-$food_item_discount;
     	  }	   	    
	  }	  	  
	  	  
	  $item_size='';
	  if (array_key_exists($item['item_size'],(array)$size)){
	  	  $item_size=$size[$item['item_size']];
	  } else $item_size='';		  
	  
	  $paypal_item[]=array(
	    'item_id'=>$item['item_id'],
	    'qty'=>$item['qty'],
	    'price'=>$item['item_price'],
	    //'item'=>$size[$item[item_size]]." ".$item['item_name']." ".$item['item_price']."X".$item['qty']
	    'item'=>$item_size." ".$item['item_name']
	  );
	  	  	  
	  if ($food_item_discount>=0.1){
	  	  //echo 'DISCOUNT '.$food_item_discount."<br/>";
	  	  $paypal_item[]=array(	  	     
	  	    'qty'=>1,
	  	    'price'=>-$food_item_discount,
	  	    'item'=>"***discount ".$food_item_discount
	  	  );
	  } 
	  
	  if (!empty($item['addon'])){
	  	 $addon_item='';
          $addon=!empty($item['addon'])?json_decode($item['addon']):false;               
           if ($addon!=FALSE){                	   
           	   foreach ($addon as $addon_val) {                       
                   $addon_item[$addon_val->subcat_id]['item'][]=$addon_val->item[0];    		
               }
          } 
	  }	  
	  	  
	  if (is_array($addon_item) && count($addon_item)>=1){
	  	 foreach ($addon_item as $key=> $addonitem){	
	  	 	//dump($addonitem);  	 	 
  	 	     $discount='';
	         if ($category=yii::app()->functions->getSubcategoryById($key)){	               	   	   
	              $discount=empty($category[0]['discount'])?"":$category[0]['discount'];
	         }	          
	         $sub_addon=0;  
	         foreach ($addonitem['item'] as $addon_sub){
	         	if ($debug){dump($addon_sub);}
	         	$paypal_item[]=array(
	         	  'item_id'=>$addon_sub->addon_id,
	         	  'qty'=>1,
	         	  'price'=>$addon_sub->price,
	         	  'item'=>ucwords($subcategory_list[$key]).
	         	"***".ucwords($subcategory_item[$addon_sub->addon_id]['sub_item_name'])
	         	);
	         	$sub_addon=$sub_addon+$addon_sub->price;
	         	//$total_addon=$total_addon+$addon_sub->price;
	         }	         
	         $discounted_amount=0;
	         if (!empty($discount)){	         	
	         	 if (preg_match("/%/i", $discount)){
	         	    $discounted_amount=preg_replace('/\D/', '', $discount);
					  if(is_numeric($discounted_amount)){					  	
						 $discounted_amount=$discounted_amount/100;
						 $temp=($sub_addon*$discounted_amount);
						 $discounted_amount=$sub_addon-$temp; 
						 if (is_numeric($discounted_amount)){		               	      	 	
						 	$discounted_amount=number_format($discounted_amount,2);
						 }
					 }
	         	 } else $discounted_amount=$discount;			       	         	 	         	 
	         	 $total_addon=$total_addon+$sub_addon-$discounted_amount;	         	 	         	 	         	 
	         	 $paypal_item[]=array(	         	   
	         	   'qty'=>1,
	         	   'price'=>-$discounted_amount,
	         	   'item'=>"***discount ".$discounted_amount
	         	 );
	         } else $total_addon=$total_addon+$sub_addon;
	  	 }	  	 
	  }	 	  
   }
	  
	  //yii::app()->functions->dump($paypal_item); 
	  if ($order_info=Yii::app()->functions->getOrderInfo($_GET['order_id'])){		
		 $trans_type=$order_info[0]['trans_type'];
	  } else $trans_type='';	
	  				  
	  $delivery_charges=0;
	  if ($trans_type=="delivery"){
	  	  $delivery_charges=yii::app()->functions->getOption("delivery_charges");
	  	   if ($delivery_charges>0){
	  	   	$paypal_item[]=array(	         	   
	          'qty'=>1,
	          'price'=>$delivery_charges,
	          'item'=>Yii::t("default","Delivery charge")
	         );
	  	   }
	  }	  
	  	  	  
	  $voucher_code=isset($_SESSION['temp_voucher_code'])?$_SESSION['temp_voucher_code']:"";
      $voucher_code_amt=isset($_SESSION['temp_voucher_amount'])?$_SESSION['temp_voucher_amount']:"";
      $voucher_type=isset($_SESSION['temp_voucher_type'])?$_SESSION['temp_voucher_type']:"";
    	            
	  /*dump($voucher_type);
	  dump($voucher_code_amt);*/
	  $convenience_charge=yii::app()->functions->getOption("convenience_charge");
	  if ( $convenience_charge>0){
	  	 $paypal_item[]=array(
	  	   'qty'=>1,
	  	   'price'=>prettyPrice($convenience_charge),
	  	   'item'=>Yii::t("default","Convenience Charge")
	  	 );
	  }	
	  
	  $grand_total=$total_item+$total_addon+$delivery_charges+$convenience_charge;
	  
	  $temp_less_percentage=0;
	  if (isset($voucher_code_amt) && is_numeric($voucher_code_amt)){
		 if ( $voucher_type=="percentage"){
			 $temp_less_percentage=$grand_total*($voucher_code_amt/100);    				
			 $grand_total=$grand_total-$temp_less_percentage;
			 $paypal_item[]=array(	         	   
		        'qty'=>1,
		        'price'=>"-".prettyPrice($temp_less_percentage),
		        'item'=>Yii::t("default","***Less Voucher")
	         );
		 } else {		 	
		 	$grand_total=$grand_total-$voucher_code_amt;	
		 	$paypal_item[]=array(	         	   
	          'qty'=>1,
	          'price'=>"-".prettyPrice($voucher_code_amt),
	          'item'=>Yii::t("default","***Less Voucher")
	        );	        
		 }		 
		 
	  }    		  
	  
	  $tax=yii::app()->functions->getOption("tax_amount");
	  $tax_amt=0;
	  if (!empty($tax)){    			
		 $tax_amt=$grand_total*($tax/100);
		 if (is_numeric($tax_amt)){
			 $tax_amt=number_format($tax_amt,2);
		 }
	  }	   
	  	  	  
	  $total_with_tax=$grand_total+$tax_amt;	  
	  if ($debug){
		  echo "GRAND TOTAL: ".$grand_total;
		  echo "<br>";
		  echo "TAX ".$tax_amt;
		  echo "<br>";
		  echo "TOTAL TAX: ".$total_with_tax;
		  echo "<br>";
	  }	  
	  
	  $paypal_con=Yii::app()->functions->getPaypalConnection();
	  
	  //dump($paypal_con);		
	  //dump($paypal_item);  
	  
	  if (is_array($paypal_item) && count($paypal_item)>=1){
	  	  $x=0;	  	  
	  	  foreach ($paypal_item as $item) {
	  	  	  //if ($debug){dump($item);}
	  	  	  $params['L_NAME'.$x]=$item['item'];
	  	  	  $params['L_NUMBER'.$x]=isset($item['item_id'])?$item['item_id']:"";
	  	  	  $params['L_DESC'.$x]='';//$item['item'];
	  	  	  $params['L_AMT'.$x]=$item['price'];
	  	  	  $params['L_QTY'.$x]=$item['qty'];
	  	  	  $x++;
	  	  }	  	  
	  	  	  	  
	  	  if ($tax_amt>0){
	  	     $params['L_NAME'.$x]="TAX";  	  	  
  	  	     $params['L_AMT'.$x]=$tax_amt;
  	  	     $params['L_QTY'.$x]=1;
	  	  }
	  	  
	  	  //$params['AMT']=$total_with_tax;
	  	  $params['AMT']=prettyPrice($total_with_tax);
	  	  //$params['ITEMAMT']=$total_with_tax;
	  	  $params['RETURNURL']="http://".$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl."/store/paypal-verify";
	  	  $params['CANCELURL']="http://".$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl;	  	  
	  	  $params['NOSHIPPING']='1';
	  	  $params['LANDINGPAGE']='Billing';
	  	  $params['SOLUTIONTYPE']='Sole';
	  	  $params['CURRENCYCODE']=yii::app()->functions->getCurrencyCodes();
	  	  
	  	  /*pre order*/
	  	  $enabled_preorder=Yii::app()->functions->getOption("enabled_preorder");
	  	  if ( $enabled_preorder==1){
	  	  	  $params['RETURNURL']=Yii::app()->getBaseUrl(true)."/store/preOrder/order_id/".$_GET['order_id']."/pmode/paypal";
	  	  }
	  	  
	  	  $paypal=new Paypal($paypal_con);
	  	  $paypal->params=$params;
	  	  $paypal->debug=false;	  	  
	  	  if ($resp=$paypal->setExpressCheckout()){	 
	  	  	  $insert['token']=$resp['token'];
	  	  	  $insert['order_id']=$_GET['order_id'];
	  	  	  $insert['date_created']=date('c');
	  	  	  $insert['ip_address']=$_SERVER['REMOTE_PORT'];	  	  	  
	  	  	  $insert['paypal_request']=json_encode($paypal->params);
	  	  	  $insert['paypal_response']=json_encode($resp['resp']);	
	  	  	  Yii::app()->functions->paypalSavedToken($insert);	  	  	  
	  	  	  header('Location: '.$resp['url']);
	  	  } else {
	  	  	 echo '<div class="alert alert-danger">'.$paypal->getError().'</div>';
	  	  }
	  } else {
	  	  echo '<div class="alert alert-danger">'.Yii::t("default","Opps Sorry but we cannot find what you are looking for.").'</div>';
	  }
  //}
  ?>
<?php else :?>
<div class="alert alert-danger"><?php echo Yii::t('default',"Opps Sorry but we cannot find what you are looking for.")?></div>
<?php  endif; ?>