<div class="receipt_main_wrapper">
<?php
yii::app()->functions->data="list";
$cooking_ref_desc=yii::app()->functions->getCookingref(); 
$subcategory_list=yii::app()->functions->getSubcategory();  
$subcategory_item=yii::app()->functions->getSubcategoryItemFullDetails(); 
$size=yii::app()->functions->getSize(); 
    	
$total_addon=0;
$discounted_amount=0;
$total_item=0;

$paypal_info=Yii::app()->functions->getPaypalTransaction($_GET['token']);

if ( $res=yii::app()->functions->getOrder($_GET['order_id']) ){		
	$client_info=Yii::app()->functions->getClientInfo($res[0]['client_id']);
	//yii::app()->functions->dump($client_info);
	?>
	<h1><?php echo yii::app()->functions->getOption('receipt_msg')?></h1>
	<div class="receipt_wrapper">
	<h2><?php echo Yii::t('default',"Receipt")?></h2>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Reference #")?>:</label>
	  <value><?php echo $_GET['order_id']?></value>
	</div>
	
	<?php if (is_array($paypal_info) && count($paypal_info)>=1):?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Paypal TRN ID")?>:</label>
	  <value><?php echo $paypal_info[0]['TRANSACTIONID']?></value>
	</div>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Paypal Payment Type")?>:</label>
	  <value><?php echo $paypal_info[0]['PAYMENTTYPE']?></value>
	</div>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Paypal Currency")?>:</label>
	  <value><?php echo $paypal_info[0]['CURRENCYCODE']?></value>
	</div>
	<?php endif;?>
	
	<?php if (!empty($client_info[0]['delivery_address'])):?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Deliver to")?>:</label>
	  <value><?php echo $client_info[0]['delivery_address']?></value>
	</div>
	<?php endif;?>
	<?php if (!empty($client_info[0]['phone'])):?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Phone Nos")?>:</label>
	  <value><?php echo $client_info[0]['phone']?></value>
	</div>
	<?php endif;?>
	<?php if (!empty($client_info[0]['mobile'])):?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Mobile Nos")?>:</label>
	  <value><?php echo $client_info[0]['mobile']?></value>
	</div>
	<?php endif;?>
	<?php foreach ($res as $item):?>
	   <?php $item['item_price']=str_replace(",","",$item['item_price'])?>
	   <?php $amount=$item['item_price']*$item['qty'];
	   $total_item=$total_item+$amount;	   
	   ?>	   
	   <?php 
	     $food_item_discount=0;
	     if ($food_item=yii::app()->functions->getFoodItemDetails($item['item_id'])){
	     	if (is_numeric($food_item[0]['discount'])){
	     	   $food_item[0]['discount']=str_replace(",","",$food_item[0]['discount']);
	     	   $food_item_discount=$food_item[0]['discount'];	
	     	   $total_item=$total_item-$food_item_discount;
	     	}	   	    
	     }
	   ?>	   
	   <div class="print_block">
	   <p><?php echo $size[$item[item_size]]." ".$item['item_name']."<br/>".$item['item_price']."@".$item['qty']?></p>
	   <value><?php echo prettyPrice($amount)?></value>	       
	   </div>
	   <div class="print_block">
	   <p class="discount_block">* <?php echo Yii::t('default',"discount")?></p>
	   <value><?php echo "(".prettyPrice($food_item_discount).")"?></value>	       
	   </div>
	       <!--START ADD ON-->
	          <?php if (!empty($item['addon'])):?>
	          <?php
	          $addon_item='';
	          $addon=!empty($item['addon'])?json_decode($item['addon']):false;               
               if ($addon!=FALSE){                	   
               	   foreach ($addon as $addon_val) {                       
                       $addon_item[$addon_val->subcat_id]['item'][]=$addon_val->item[0];    		
                   }
              }              
              //dump($addon_item);
	          ?>	             
	          <?php if (is_array($addon_item) && count($addon_item)>=1):?>
	          <div class="print_addon_wrap">	          
	          <?php foreach ($addon_item as $key=> $addonitem):?>	
	          <?php 
	          $discount='';
	          if ($category=yii::app()->functions->getSubcategoryById($key)){	               	   	   
	              $discount=empty($category[0]['discount'])?"":$category[0]['discount'];
	          }	            	               	 
	          ?>          
	          <i><?php echo $subcategory_list[$key]?></i>
	              <?php $sub_addon=0; ?>
	              <?php foreach ($addonitem['item'] as $addon_sub):?>	              
	              <div class="addon_block">
	                <label><?php echo $subcategory_item[$addon_sub->addon_id]['sub_item_name']?></label>
	                <value><?php echo prettyPrice($addon_sub->price)?></value>
	              </div>
	              <?php //$total_addon=$total_addon+$addon_sub->price?>
	              <?php $sub_addon=$sub_addon+$addon_sub->price;?>
	              <?php endforeach;?>
	              <!--DISCOUNT-->
	              <?php if (!empty($discount)):?>
	                 <?php if (preg_match("/%/i", $discount)):?>
	                 <?php
					  $discounted_amount=preg_replace('/\D/', '', $discount);
					  if(is_numeric($discounted_amount)){
						 $discounted_amount=$discounted_amount/100;
						 $temp=($sub_addon*$discounted_amount);
						 $discounted_amount=$sub_addon-$temp; 
						 if (is_numeric($discounted_amount)){		               	      	 	
						 	$discounted_amount=number_format($discounted_amount,2);
						 }
					 }
	                 ?>
	                 <?php else :?>
	                 <?php $discounted_amount=$discount;?>
	                 <?php endif;?>
	                 <div class="addon_block">
	                 <label>* <?php echo Yii::t('default',"discount")?></label>
	                 <value>(<?php echo $discounted_amount;?>)</value>
	                 </div>
	                 <?php //$total_addon=$total_addon-$discounted_amount;?>	                 	                 
                  <?php else :?> 	                  
                    <?php $total_addon=$total_addon+$sub_addon;?>
	              <?php endif;?>	
	              <!--DISCOUNT-->              
	              <?php $total_addon=$total_addon+$sub_addon-$discounted_amount;?>
	          <?php endforeach;?>
	          </div> <!--END print addon_wrap-->
	          <?php endif;?>
	          <?php endif;?>
	       <!--END ADD ON-->	  
	<?php endforeach;?>		
	
	<?php
	$grand_total=$total_item+$total_addon;
	$tax=yii::app()->functions->getOption("tax_amount");
	$tax_amt=0;
	if (!empty($tax)){    			
		$tax_amt=$grand_total*($tax/100);
		if (is_numeric($tax_amt)){
			$tax_amt=number_format($tax_amt,2);
		}
	} 	
	?>
	<div class="total_wrap">
	  <div class="print_block">
	    <label><?php echo Yii::t('default',"Total")?>:</label>
	    <value><?php echo baseCurr().prettyPrice($grand_total);?></value>
	  </div>
	  <div class="print_block">
	    <label><?php echo Yii::t('default',"Tax")?> <?php echo $tax;?> %:</label>
	    <value><?php echo baseCurr().prettyPrice($tax_amt);?></value>
	  </div>
	  <div class="print_block">
	    <label><?php echo Yii::t('default',"Total with Tax")?>:</label>
	    <value><?php echo baseCurr().prettyPrice($grand_total+$tax_amt);?></value>
	  </div>
	</div> <!--total_wrap-->
	
	</div> <!--END receipt_wrapper-->
	<p class="print"><?php echo Yii::t('default',"CLick here to")?> <a href="javascript:window.print();"><?php echo Yii::t('default',"print")?></a> </p>
	<?php
	
	/*UPATE THE TABLE WITH TOTAL AND WITH TAX TOTAL*/
	$params['total']=$grand_total;
	$params['tax']=$tax_amt;
	$params['total_w_tax']=$grand_total+$tax_amt;
	//$params['status']='paid';
	yii::app()->functions->updateSalesOrder($params,$_GET['order_id']);	
} else {
	?>
	<div class="alert alert-danger"><?php echo Yii::t('default',"Sorry but we cannot find what you are looking for")?>.</div>
	<?php
}
?>
</div> <!--END receipt_main_wrapper-->