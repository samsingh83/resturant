<div class="paypal_verify">
<?php
yii::app()->functions->data="list";
$cooking_ref_desc=yii::app()->functions->getCookingref(); 
$subcategory_list=yii::app()->functions->getSubcategory();  
$subcategory_item=yii::app()->functions->getSubcategoryItemFullDetails(); 
$size=yii::app()->functions->getSize(); 

$debug=false;

$paypal_con=Yii::app()->functions->getPaypalConnection();
$paypal=new Paypal($paypal_con);

$total_item=0;
$total_addon=0;

if ($res_paypal=$paypal->getExpressDetail()):?>
<h3><?php echo Yii::t("default","Your Information")?></h3>
<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t("default","Name")?>*</span>
<input type="text" readonly name="name" class="form-control" value="<?php echo $res_paypal['FIRSTNAME']." ".$res_paypal['LASTNAME']?>">
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t("default","Paypal Email")?>*</span>
<input type="text" readonly name="name" class="form-control" value="<?php echo $res_paypal['EMAIL']?>">
</div>

<h3><?php echo Yii::t("default","Your Order Information")?></h3>
<p><?php echo Yii::t("default","Please check your order below")?>.</p>
	<?php if ($info=Yii::app()->functions->getOrderByPaypalToken($_GET['token'])): ?>	   
	   <?php if ( $res=yii::app()->functions->getOrder($info[0]['order_id'])):?>
	      <?php 
	      $order_id=$info[0]['order_id'];
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
			  if (array_key_exists($item['item_size'],$size)){
			  	  $item_size=$size[$item['item_size']];
			  } else $item_size='';
			  $paypal_item[]=array(
			    'item_id'=>$item['item_id'],
			    'qty'=>$item['qty'],
			    'price'=>$item['item_price'],
			    //'item'=>$size[$item[item_size]]." ".$item['item_name']." ".$item['item_price']."X".$item['qty']
			    'item'=>$item_size." ".$item['item_name']
			  );
			  
			  if ($food_item_discount>=1){
			  	  //echo 'DISCOUNT '.$food_item_discount."<br/>";
			  	  $paypal_item[]=array(	  	     
			  	    'qty'=>1,
			  	    'item'=>Yii::t("default","***discount")." ".$food_item_discount
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
			         	   'item'=>Yii::t("default","***discount")." ".$discounted_amount
			         	 );
			         } else $total_addon=$total_addon+$sub_addon;
			  	 }	  	 
			  }	 	  
	      }
	      
	      /*DELIVERY CHARGES*/
	      if ($order_info=Yii::app()->functions->getOrderByPaypalToken($_GET['token'])){		
		     $trans_type=$order_info[0]['trans_type'];
	      } else $trans_type='';	
	      
	      $delivery_charges=0;
		  if ($trans_type=="delivery"){
		  	  $delivery_charges=yii::app()->functions->getOption("delivery_charges");		  	   
		  }	  
		  
		   $convenience_charge=yii::app()->functions->getOption("convenience_charge");	
	      	      	      	      	      	    
	       $grand_total=$total_item+$total_addon+$delivery_charges+$convenience_charge;
	       	       
	       /*VOUCHER*/	       
	       $voucher_code_amt='';
	       $orderinfo=Yii::app()->functions->getOrderInfo($order_info[0]['order_id']);	       
	       if (is_array($orderinfo) && count($orderinfo)>=1){
	       	  $orderinfo=$orderinfo[0];	       	  
	       	  $voucher_code=isset($orderinfo['voucher_code'])?$orderinfo['voucher_code']:"";
              $voucher_code_amt=isset($orderinfo['voucher_amount'])?$orderinfo['voucher_amount']:"";
              $voucher_type=isset($orderinfo['voucher_type'])?$orderinfo['voucher_type']:"";
              $temp_less_percentage=0;              
			  if (isset($voucher_code_amt) && is_numeric($voucher_code_amt)){
				 if ( $voucher_type=="percentage"){
					 $temp_less_percentage=$grand_total*($voucher_code_amt/100);  
					 $voucher_code_amt=$temp_less_percentage;					 
					 $grand_total=$grand_total-$temp_less_percentage;
				 } else $grand_total=$grand_total-$voucher_code_amt;  				 
			  }    		  
              
	       }
	       /*VOUCHER*/
	       
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
			/*  echo "GRAND TOTAL: ".$grand_total;
			  echo "<br>";
			  echo "TAX ".$tax_amt;
			  echo "<br>";
			  echo "TOTAL TAX: ".$total_with_tax;
			  echo "<br>";*/
		  }
	      ?>
	      <?php if (is_array($paypal_item) && count($paypal_item)>=1):?>	      
	           <div class="input_block_1 header_table">
	              <div class="item label label-primary"><?php echo Yii::t("default","Item")?></div>
	              <div class="qty label label-primary"><?php echo Yii::t("default","Qty")?></div>
	              <div class="price label label-primary"><?php echo Yii::t("default","Price")?></div>	              
	            </div>	             	            	            
	          <?php foreach ($paypal_item as $val):?>
	            <div class="input_block_1">
	              <div class="item"><?php echo $val['item']?></div>
	              <div class="qty"><?php echo $val['qty']?></div>
	              <div class="price"><?php echo isset($val['price'])?$val['price']:""?></div>	              
	           </div>	             	            
	          <?php endforeach;?>
	          
	          <?php if ($delivery_charges>0):?>
	          <div class="input_block_1">
	            <div class="item"><?php echo Yii::t("default","Delivery charge")?></div>
	            <div class="qty"></div>
	            <div class="price"><?php echo prettyPrice($delivery_charges)?></div>	              
	          </div>
	          <?php endif;?>
	          
	          <?php if ( $convenience_charge>0):?>
	          <div class="input_block_1">
	            <div class="item"><?php echo Yii::t("default","Convenience Charge")?></div>
	            <div class="qty"></div>
	            <div class="price"><?php echo prettyPrice($convenience_charge)?></div>	              
	          </div>
	          <?php endif;?>
	          
	          <?php if (is_numeric($voucher_code_amt)):?>
	          <div class="input_block_1">
	              <div class="item"><?php echo Yii::t("default","Less Voucher")?></div>
	              <div class="qty">&nbsp;</div>
	              <div class="price">-<?php echo  prettyPrice($voucher_code_amt)?></div>	              
	           </div>	             	       
	           <?php endif;?>

	          <div class="spacer"></div>
	                    
	          <div class="input_block_1">
	              <div class="item"><?php echo Yii::t("default","Total Amount")?></div>
	              <div class="qty">&nbsp;</div>
	              <div class="price"><?php echo  prettyPrice($grand_total)?></div>	              
	           </div>	             	       
	                
	           <?php if ($tax>=1):?>
	           <div class="input_block_1">
	              <div class="item"><?php echo Yii::t("default","Tax")?> <?php echo $tax?>%</div>
	              <div class="qty">&nbsp;</div>
	              <div class="price"><?php echo  prettyPrice($tax_amt)?></div>	              
	           </div>
	           <div class="input_block_1">
	              <div class="item"><?php echo Yii::t("default","TOTAL W TAX")?>:</div>
	              <div class="qty">&nbsp;</div>
	              <div class="price"><?php echo  prettyPrice($total_with_tax)?></div>	              
	           </div>	          
	           <?php endif;?> 	           
	            <form method="POST" id="frm_paypal_checkout" onsubmit="return false;">				
				<input type="hidden" name="token" value="<?php echo $_GET['token']?>">
				<input type="hidden" name="payerid" value="<?php echo $res_paypal['PAYERID']?>">
				<input type="hidden" name="amount" value="<?php echo $res_paypal['AMT']?>">
				<input type="hidden" name="action" value="paypalCheckoutPayment">
				<input type="hidden" name="order_id" value="<?php echo $order_id;?>">
				<input type="submit" id="purchase_btn" value="<?php echo Yii::t("default","Purchase Now")?>" class="mybtn buttonorange">
				</form>
	          
	      <?php else :?>
	      <div class="alert alert-danger"><?php echo Yii::t("default","Opps Sorry but we cannot find what your order information")?>.</div>
	      <?php endif;?>
	   <?php else :?>
	   <div class="alert alert-danger"><?php echo Yii::t("default","Opps Sorry but we cannot find what your order information")?>.</div>
	   <?php endif;?>
	<?php else :?>
	<div class="alert alert-danger"><?php echo Yii::t("default","Opps Sorry but we cannot find what your order information")?>.</div>
	<?php endif;?>

<?php else :?>
<?php echo _('<div class="alert alert-danger">'.$paypal->getError().'</div>');?>
<?php endif;?>
</div>