<?php yii::app()->functions->sessionInit();?> 
<div id="postContent">
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
$pr_tbl='';

if ($paypal_info=Yii::app()->functions->getPaypalTransactionByOrderId($_GET['order_id'])){	
} else $paypal_info=array();

$receipt_bol=false;

if ( $res=yii::app()->functions->getOrder($_GET['order_id']) ){		
	$client_info=Yii::app()->functions->getClientInfo($res[0]['client_id']);	
	if ($order_info=Yii::app()->functions->getOrderInfo($_GET['order_id'])){		
		$trans_type=$order_info[0]['trans_type'];
	} else $trans_type='';				
	
	$voucher_code=!empty($order_info[0]['voucher_code'])?$order_info[0]['voucher_code']:"";
    $voucher_code_amt=!empty($order_info[0]['voucher_amount'])?$order_info[0]['voucher_amount']:"";    
    $voucher_type=!empty($order_info[0]['voucher_type'])?$order_info[0]['voucher_type']:"";    
	?>		
	<?php ob_start();?>
	<div class="receipt_wrapper">
	<h2><?php echo Yii::t('default',"Order Detail")?> </h2>
	
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Name")?> :</label>
	  <value><?php echo $client_info[0]['fullname']?></value>
	</div>
	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td style=\"width:150px\">".Yii::t("default","Name")." :</td>";
	$pr_tbl.="<td>".$client_info[0]['fullname']."</td>";
	$pr_tbl.="</tr>";
	?>
	
	<div class="print_block">
	  <label><?php echo Yii::t('default',"TRN Type")?> :</label>
	  <value><?php echo Yii::t("default",ucwords($trans_type))?></value>
	</div>
	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","TRN Type")." :</td>";
	$pr_tbl.="<td>".Yii::t("default",ucwords($trans_type))."</td>";
	$pr_tbl.="</tr>";
	?>
	
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Payment Type")?> :</label>
	  <value><?php echo Yii::t("default",$order_info[0]['payment_type'])?></value>
	</div>
	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Payment Type")." :</td>";
	$pr_tbl.="<td>".Yii::t("default",$order_info[0]['payment_type'])."</td>";
	$pr_tbl.="</tr>";
	?>
	
   <?php if ($order_info[0]['payment_type']=="creditcard"):?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"CreditCard TransId")?> :</label>
	  <value><?php echo Yii::t("default",$order_info[0]['braintree_id'])?></value>
	</div>
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","CreditCard TransId")." :</td>";
	$pr_tbl.="<td>".Yii::t("default",$order_info[0]['braintree_id'])."</td>";
	$pr_tbl.="</tr>";
	?>
	<?php endif;?>
	
		
	<?php if ( $order_info[0]['payment_type']=="card"):?>
	<?php 
	   $credit_card_number='';
	   if ($card_info=Yii::app()->functions->getCreditCardInfo( $order_info[0]['cc_id'])){	   	   
	   	   $credit_card_number=Yii::app()->functions->maskCardnumber($card_info['credit_card_number']);
	   }	   
	?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Card Number")?> :</label>
	  <value><?php echo $credit_card_number?></value>
	</div>
	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Card Number")." :</td>";
	$pr_tbl.="<td>".$credit_card_number."</td>";
	$pr_tbl.="</tr>";
	?>	
	<?php endif;?>
	
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Reference #")?>:</label>
	  <value><?php echo $_GET['order_id']?></value>
	</div>
	
	<div class="print_block">
	  <label><?php echo Yii::t('default',"TRN Date")?>:</label>
	  <value><?php echo !empty($order_info[0]['date_created'])?date('M d,Y G:i:s',strtotime($order_info[0]['date_created'])):"";?></value>
	</div>
	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Reference #").":</td>";
	$pr_tbl.="<td>".$_GET['order_id']."</td>";
	$pr_tbl.="</tr>";
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","TRN Date").":</td>";
	$pr_tbl.="<td>".$order_info[0]['date_created']."</td>";
	$pr_tbl.="</tr>";
	?>
	
	<?php if (is_array($paypal_info) && count($paypal_info)>=1):?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Paypal TRN ID")?>:</label>
	  <value><?php echo $paypal_info[0]['TRANSACTIONID']?></value>
	</div>
	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Paypal TRN ID").":</td>";
	$pr_tbl.="<td>".$paypal_info[0]['TRANSACTIONID']."</td>";
	$pr_tbl.="</tr>";
	?>
	
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Paypal Payment Type")?>:</label>
	  <value><?php echo $paypal_info[0]['PAYMENTTYPE']?></value>
	</div>
	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Paypal Payment Type").":</td>";
	$pr_tbl.="<td>".$paypal_info[0]['PAYMENTTYPE']."</td>";
	$pr_tbl.="</tr>";
	?>
	
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Paypal Currency")?>:</label>
	  <value><?php echo $paypal_info[0]['CURRENCYCODE']?></value>
	</div>
	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Paypal Currency").":</td>";
	$pr_tbl.="<td>".$paypal_info[0]['CURRENCYCODE']."</td>";
	$pr_tbl.="</tr>";
	?>
	
	<?php endif;?>
	
	<?php if ($trans_type=="delivery"):?>
	
	   <?php if ( $order_info[0]['delivery_asap']==2):?>
		    <div class="print_block">
			  <label><?php echo Yii::t('default',"Deliver Date")?>:</label>
			  <value><?php echo Yii::t("default","ASAP")?></value>
			</div>
			<?php 
			$pr_tbl.="<tr>";
			$pr_tbl.="<td>".Yii::t("default","Deliver Date").":</td>";
			$pr_tbl.="<td>".Yii::t("default","ASAP")."</td>";
			$pr_tbl.="</tr>";
			?>
		<?php else :?>
		   <?php if ( $order_info[0]['delivery_date']!="0000-00-00 00:00:00"):?>
			<div class="print_block">
			  <label><?php echo Yii::t('default',"Deliver Date")?>:</label>
			  <value><?php echo date("M,d Y",strtotime($order_info[0]['delivery_date']))?></value>
			</div>		
			<?php 
			$pr_tbl.="<tr>";
			$pr_tbl.="<td>".Yii::t("default","Deliver Date").":</td>";
			$pr_tbl.="<td>".date("M,d Y",strtotime($order_info[0]['delivery_date']))."</td>";
			$pr_tbl.="</tr>";
			?>
			<?php endif;?>
		<?php endif;?>
		
	    <?php if ( $order_info[0]['delivery_time']!=""):?>
		<div class="print_block">
		  <label><?php echo Yii::t('default',"Deliver Time")?>:</label>
		  <value><?php echo $order_info[0]['delivery_time']?></value>
		</div>
		<?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>".Yii::t("default","Deliver Time").":</td>";
		$pr_tbl.="<td>".$order_info[0]['delivery_time']."</td>";
		$pr_tbl.="</tr>";
		?>
		<?php endif;?>
		
		
		<?php if (!empty($client_info[0]['delivery_address'])):?>
		<div class="print_block">
		  <label><?php echo Yii::t('default',"Deliver to")?>:</label>
		  <value><?php echo $client_info[0]['delivery_address']?></value>
		</div>
		<div class="print_block">
		  <label><?php echo Yii::t('default',"Delivery Instruction")?>:</label>
		  <value><?php echo $client_info[0]['delivery_instruction']?></value>
		</div>
		<div class="print_block">
		  <label><?php echo Yii::t('default',"Location Name")?>:</label>
		  <value><?php echo $client_info[0]['location_name']?></value>
		</div>
		<?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>".Yii::t("default","Deliver to").":</td>";
		$pr_tbl.="<td>".$client_info[0]['delivery_address']."</td>";
		$pr_tbl.="</tr>";
		?>
		<?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>".Yii::t("default","Delivery Instruction").":</td>";
		$pr_tbl.="<td>".$client_info[0]['delivery_instruction']."</td>";
		$pr_tbl.="</tr>";
		?>
		<?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>".Yii::t("default","Location Name").":</td>";
		$pr_tbl.="<td>".$client_info[0]['location_name']."</td>";
		$pr_tbl.="</tr>";
		?>
		<?php endif;?>
	<?php endif;?>
	
	<?php if (!empty($client_info[0]['phone'])):?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Phone Nos")?>:</label>
	  <value><?php echo $client_info[0]['phone']?></value>
	</div>
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Phone Nos").":</td>";
	$pr_tbl.="<td>".$client_info[0]['phone']."</td>";
	$pr_tbl.="</tr>";
	?>
	<?php endif;?>
	<?php if (!empty($client_info[0]['mobile'])):?>
	<div class="print_block">
	  <label><?php echo Yii::t('default',"Mobile Nos")?>:</label>
	  <value><?php echo $client_info[0]['mobile']?></value>
	</div>
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Mobile Nos").":</td>";
	$pr_tbl.="<td>".$client_info[0]['mobile']."</td>";
	$pr_tbl.="</tr>";
	?>
	<?php endif;?>
	<?php foreach ($res as $item): //dump($item)?>
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
	   <p><?php 
	   if (array_key_exists($item['item_size'],$size)){
	       echo $item_size=$size[$item['item_size']]." ".$item['item_name']."<br/>".$item['item_price']."X".$item['qty'];
	   } else echo $item_size=$item['item_name']."<br/>".$item['item_price']."X".$item['qty'];
	   ?></p>
	   <value><?php echo prettyPrice($amount)?></value>	       
	   </div>
	   
	   <?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td style=\"font-weight:bold;\">".$item_size."</td>";
		$pr_tbl.="<td>".prettyPrice($amount)."</td>";
		$pr_tbl.="</tr>";
		?>
	   
	   <?php if (!empty($item['order_notes'])):?>
	   <div>
	   <label  style="font-size:13px;"><?php echo Yii::t('default',"Notes")?>: <?php echo $item['order_notes'];?></label>	   
	   </div>
	   <?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>Notes:</td>";
		$pr_tbl.="<td>".$item['order_notes']."</td>";
		$pr_tbl.="</tr>";
		?>
	   <?php endif;?>
	   
	   
	   <!--MULTI OPTIONS-->
	   <?php	   
	   $multi_id_selected=isset($item['multi_id'])?json_decode($item['multi_id']):"";	  
	   $multi_description=Yii::app()->functions->getMultiOptionList(); 	   
	   ?>
	   <?php if ( $multi_id_selected!=FALSE ):?>
	   <div class="print_block"> 
	     <label><?php echo Yii::t("default","Sides")?></label>
	   </div>
	   <?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>Sides:</td>";
		$pr_tbl.="<td></td>";
		$pr_tbl.="</tr>";
		?>
	   <?php foreach ($multi_id_selected as $multi_val):?>
	    <?php if (array_key_exists($multi_val,(array)$multi_description)):?>
	      <div class="print_block">
	      <label>- <?php echo $multi_description[$multi_val]?></label>
	      <value>-</value>
	      </div>	
	      
	      <?php 
		  $pr_tbl.="<tr>";
		  $pr_tbl.="<td>- ".$multi_description[$multi_val]."</td>";
		  $pr_tbl.="<td></td>";
		  $pr_tbl.="</tr>";
		 ?>
		
	    <?php endif;?>
	   <?php endforeach;?>
	   <?php endif;?>
	   <!--MULTI OPTIONS-->

	   
	   <?php if ($food_item_discount>=1):?>
	   <div class="print_block">
	   <p class="discount_block">* <?php echo Yii::t('default',"discount")?></p>
	   <value><?php echo "(".prettyPrice($food_item_discount).")"?></value>	       
	   </div>
	   <?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>".Yii::t("default","* discount")."</td>";
		$pr_tbl.="<td>"."(".prettyPrice($food_item_discount).")"."</td>";
		$pr_tbl.="</tr>";
		?>
	   <?php endif;?>
	   
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
	              
<?php 
$pr_tbl.="<tr>";
$pr_tbl.="<td colspan=\"2\" style=\"padding-left:8px;\"><strong>".$subcategory_list[$key]."</strong></td>";				
$pr_tbl.="</tr>";

$pr_tbl.="<tr>";
$pr_tbl.="<td style=\"padding-left:8px;\">".$subcategory_item[$addon_sub->addon_id]['sub_item_name']."</td>";
$pr_tbl.="<td>".prettyPrice($addon_sub->price)."</td>";
$pr_tbl.="</tr>";
?>
				
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
	                 <?php 
					$pr_tbl.="<tr>";
					$pr_tbl.="<td>".Yii::t("default","* discount")."</td>";
					$pr_tbl.="<td>(".$discounted_amount.")</td>";
					$pr_tbl.="</tr>";
					?>
					
	                 <?php else :?>
	                 <?php $discounted_amount=$discount;?>
	                 <?php endif;?>
	                 <div class="addon_block">
	                 <label>* <?php echo Yii::t('default',"discount")?></label>
	                 <value>(<?php echo $discounted_amount;?>)</value>
	                 </div>
	                 <?php $total_addon=$total_addon+$sub_addon-$discounted_amount;?>
                  <?php else :?> 	                  
                    <?php $total_addon=$total_addon+$sub_addon-$discounted_amount;?>
	              <?php endif;?>	
	              <!--DISCOUNT-->              
	              <?php //$total_addon=$total_addon+$sub_addon-$discounted_amount;?>
	              <?php //$total_addon=$total_addon+$sub_addon;?>
	              
	              <?php 	              
	              $sub_addon=0;
	              $discounted_amount=0;
	              ?>
	              
	          <?php endforeach;?>
	          </div> <!--END print addon_wrap-->
	          <?php endif;?>
	          <?php endif;?>
	       <!--END ADD ON-->	  
	<?php endforeach;?>		
	
	<?php		
	//dump($order_info);
	$delivery_charge=0;
	if ($order_info[0]['delivery_charge']>0){
		$delivery_charge=$order_info[0]['delivery_charge'];
		?>
		<div class="print_block">
		<p><?php echo Yii::t("default","Delivery charge")?></p>
	    <value><?php echo prettyPrice($delivery_charge);?></value>
		</div>
		<?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>".Yii::t("default","Delivery charge")."</td>";
		$pr_tbl.="<td>".prettyPrice($delivery_charge)."</td>";
		$pr_tbl.="</tr>";
		?>
		<?php
	}
		
	//$convenience_charge=yii::app()->functions->getOption("convenience_charge");	
	$convenience_charge=$order_info[0]['convenience_charge'];
	?>	
	<?php if ( $convenience_charge>0):?>
	<div class="print_block">
	 <p><?php echo Yii::t("default","Convenience Charge")?></p>
	 <value><?php echo prettyPrice($convenience_charge);?></value>
	</div>	
	<?php 
	$pr_tbl.="<tr>";
	$pr_tbl.="<td>".Yii::t("default","Convenience Charge")."</td>";
	$pr_tbl.="<td>".prettyPrice($convenience_charge)."</td>";
	$pr_tbl.="</tr>";	
	else :
	$convenience_charge=0;
	endif;
				
	
	$grand_total=$total_item+$total_addon+$delivery_charge+$convenience_charge;
	$temp_less_percentage=0;
	
	if ( !empty($voucher_code) && is_numeric($voucher_code_amt) ){		
		if ( $voucher_type=="percentage"){
			$temp_less_percentage=$grand_total*($voucher_code_amt/100);    				
    	    $grand_total=$grand_total-$temp_less_percentage;
		} else $grand_total=$grand_total-$voucher_code_amt;		
	}		
	?>
	<?php if ( !empty($voucher_code) && is_numeric($voucher_code_amt) ):?>
	<?php if ( $voucher_type=="percentage"):?>
	    <div class="print_block">	    
		<p><?php echo Yii::t("default","Less Voucher")." $voucher_code_amt %"?></p>
		<value>- (<?php echo prettyPrice($temp_less_percentage);?>)</value>
		</div>
		<?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>".Yii::t("default","Less Voucher")." $voucher_code_amt %</td>";
		$pr_tbl.="<td>"."- (".prettyPrice($temp_less_percentage).")</td>";
		$pr_tbl.="</tr>";
		?>
	<?php else :?>
		<div class="print_block">
		 <p><?php echo Yii::t("default","Less Voucher")?></p>
		 <value>- (<?php echo prettyPrice($voucher_code_amt);?>)</value>
		</div>
		<?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td>".Yii::t("default","Less Voucher")."</td>";
		$pr_tbl.="<td>"."- (".prettyPrice($voucher_code_amt).")</td>";
		$pr_tbl.="</tr>";
		?>
	<?php endif;?>
	<?php endif;?>
	<?php
			
	$tax=yii::app()->functions->getOption("tax_amount");			
	$tax_amt=0;
	/*if (!empty($tax)){    			
		$tax_amt=$grand_total*($tax/100);
		if (is_numeric($tax_amt)){
			$tax_amt=number_format($tax_amt,2);
		}
	}*/
	//$tax_amt=$order_info[0]['tax'];
	
	if ($order_info[0]['set_tax']>0){
		$tax=$order_info[0]['set_tax'];
	}	
	$tax_amt=$order_info[0]['tax'];
	?>
	<div class="total_wrap">
	  <div class="print_block">
	    <label><?php echo Yii::t('default',"Total")?>:</label>
	    <value><?php echo baseCurr().prettyPrice($grand_total);?></value>
	  </div>
	  <?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td style=\"border-top:1px solid #000;\" >".Yii::t("default","Total").":</td>";
		$pr_tbl.="<td  style=\"border-top:1px solid #000;\">".baseCurr().prettyPrice($grand_total)."</td>";
		$pr_tbl.="</tr>";
	  ?>	  
	  <?php if ($tax_amt>0):?>
	  <div class="print_block">
	    <label><?php echo Yii::t('default',"Tax")?> <?php echo $tax;?> %:</label>
	    <value><?php echo baseCurr().prettyPrice($tax_amt);?></value>
	  </div>
	  <?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td >".Yii::t("default","Tax")." ".$tax."%:</td>";
		$pr_tbl.="<td>".baseCurr().prettyPrice($tax_amt)."</td>";
		$pr_tbl.="</tr>";
	  ?>
	  <div class="print_block">
	    <label><?php echo Yii::t('default',"Total with Tax")?>:</label>
	    <value><?php echo baseCurr().prettyPrice($grand_total+$tax_amt);?></value>
	  </div>
	  <?php 
		$pr_tbl.="<tr>";
		$pr_tbl.="<td style=\"font-weight:bold;\">".Yii::t("default","Total with Tax").":</td>";
		$pr_tbl.="<td>".baseCurr().prettyPrice($grand_total+$tax_amt)."</td>";
		$pr_tbl.="</tr>";
		?>
	  <?php endif;?>
	</div> <!--total_wrap-->
		
	</div> <!--END receipt_wrapper-->	
	
	<div class="print_wrap">
    <a href="javascript:;" class="print_element left"><i class="fa fa-print"></i> 
    <?php echo Yii::t("default","Click here to print")?></a>
    <a target="_blank" href="<?php echo Yii::app()->request->baseUrl;?>/store/receiptpdf" class="right">
    <i class="fa fa-cloud-download"></i> <?php echo Yii::t("default","Print to PDF")?></a>
    <div class="clear"></div>
    </div>
    
	<?php		
	$receipt = ob_get_contents();
    ob_end_clean();
    echo $receipt;
} else {
	?>
	<div class="alert alert-danger"><?php echo Yii::t('default',"Sorry but we cannot find what you are looking for")?>.</div>
	<?php
}
?>
</div> <!--END receipt_main_wrapper-->
</div> <!--END postContent-->

<?php
$receipt_html='';
$receipt_html.='<h2 style="color:#D23919;font-weight:normal;font-size:22px;font-family:arial;">Receipt</h2>';
$receipt_html.="<DIV style=\"border:1px solid #000;padding:8px;width:400px;\">";
$receipt_html.="<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size:14px;font-family:arial;\" >";
$receipt_html.=$pr_tbl;
$receipt_html.="</table>";
$receipt_html.="</DIV>";

/*saved for printing pdf*/
$_SESSION['receipt_pdf']=$receipt_html;
?>