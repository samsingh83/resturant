<?php
/*******************************************
@author : bastikikang 
@author email: basti@codemywebapps.com
@author website : http://codemywebapps.com
*******************************************/

if (!isset($_SESSION)) { session_start(); }

class AjaxSites
{
	public $data;
	public $code=2;
	public $msg;
	public $details;
	
	public function output($debug=FALSE)
	{
	    $resp=array('code'=>$this->code,'msg'=>$this->msg,'details'=>$this->details);
	    if ($debug){
		    dump($resp);
	    }
	    return json_encode($resp);    	    
    }
    
    public function notExistMethod()
    {
    	$this->msg=Yii::t("default","Method does not exist");
    }
    
    public function addToCart()
    {       	
    	if (!isset($this->data['cooking_ref'])){
    		$this->data['cooking_ref']='';
    	}    	
    	//dump($this->data);    	
    	/*$test=json_decode($this->data['addon']);    	
    	foreach ($test as $val) {
    		dump($val);
    		$datas[$val->subcat_id]['item'][]=$val->item[0];    		
    	}*/
    	//dump($this->data); 
    	if (isset($this->data['item_row']) && is_numeric($this->data['item_row']) ){ 
    		//echo 'd2';    		
    		$_SESSION[KARENDERIA]['item'][$this->data['item_row']]=array(
	    	  'item_id'=>$this->data['item-id'],
	    	  'item_size'=>$this->data['item_size'],
	    	  'order_notes'=>$this->data['order_notes'],
	    	  'item_price'=>$this->data['item_price'],
	    	  'qty'=>$this->data['qty'],
	    	  'cooking_ref'=>$this->data['cooking_ref'],
	    	  'addon'=>$this->data['addon'],
	    	  'multi_id'=>$this->data['multi_id']
    	   );
    	} else {
    		//echo 'd1';
	    	$_SESSION[KARENDERIA]['item'][]=array(
	    	  'item_id'=>$this->data['item-id'],
	    	  'item_size'=>$this->data['item_size'],
	    	  'order_notes'=>$this->data['order_notes'],
	    	  'item_price'=>$this->data['item_price'],
	    	  'qty'=>$this->data['qty'],
	    	  'cooking_ref'=>$this->data['cooking_ref'],
	    	  'addon'=>$this->data['addon'],
	    	  'multi_id'=>$this->data['multi_id']
	    	);
    	}
    	$this->code=1;
    	$this->msg=Yii::t("default","OK");
    }   
    
    public function loadCartItem()
    {    	
    	    	
    	//unset($_SESSION[KARENDERIA]);    	    
    	yii::app()->functions->data="list";
    	$cooking_ref_desc=yii::app()->functions->getCookingref(); 
    	$subcategory_list=yii::app()->functions->getSubcategory();  
    	$subcategory_item=yii::app()->functions->getSubcategoryItemFullDetails(); 
    	$size=yii::app()->functions->getSize();     	
    	//dump($subcategory_item);
    	
    	//dump($subcategory_list);    	
    	//dump($_SESSION[KARENDERIA]['item']);
    	//dump($subcategory_list);
    	$htmls='';
    	$addon_total=0;
    	$item_total=0;
    	$html='';
    	$addon_item='';    	
    	
    	if (!isset($_SESSION[KARENDERIA]['item'])){
    		$_SESSION[KARENDERIA]['item']='';
    	}    
    	
    	$voucher_code=isset($_SESSION['temp_voucher_code'])?$_SESSION['temp_voucher_code']:"";
    	$voucher_code_amt=isset($_SESSION['temp_voucher_amount'])?$_SESSION['temp_voucher_amount']:"";
    	$voucher_type=isset($_SESSION['temp_voucher_type'])?$_SESSION['temp_voucher_type']:"";
    	
    	$multi_opt=yii::app()->functions->getMultiOptionList();     	
    	
    	if (is_array($_SESSION[KARENDERIA]['item']) && count($_SESSION[KARENDERIA]['item'])>=1){
    		
    		//$html="<ul>";
    		foreach ($_SESSION[KARENDERIA]['item'] as $item_key => $item) {    			    		   
    		   //dump($item);
    		   $qty=$item['qty'];
    		   $food_item=yii::app()->functions->getFoodItemDetails($item['item_id']);     		   
    		   $food_item_discount=0;    		   
    		   if (!empty($food_item[0]['discount'])){
    		       $food_item_discount=$food_item[0]['discount'];
    		   }
    		   $html.="<li>";
			   $html.="<img title=\"\" alt=\"\" src=\"".Yii::app()->request->baseUrl."/upload/".$food_item[0]['photo']."\">";
               $html.=  "<div class=\"details\">";
               $html.=  "<H4>".$qty."X ".$food_item[0]['item_name']."</H4>";
               if ($item['item_size']>=1){
                   $html.=  "<p>".$size[$item['item_size']]."</p>";               
               }
               if (isset($item['cooking_ref']) && !empty($item['cooking_ref'])){
                  $html.=  "<h5>".Yii::t("default","Cooking Preference")." :</h5>";
                  if (array_key_exists($item['cooking_ref'],(array)$cooking_ref_desc)){
                  	  $html.=  "<p>".$cooking_ref_desc[$item['cooking_ref']]."</p>";
                  }                  
               }  
               $html.=  "<h5>".Yii::t("default","Notes")." :</h5>";
               $html.=  "<p class=\"long_notes\">".$item['order_notes']."</p>";
               $addon=!empty($item['addon'])?json_decode($item['addon']):false;
               
               
               /*MULTI ITEM*/
               if (isset($item['multi_id'])){
               	   if (is_array($item['multi_id']) && count($item['multi_id'])>=1){               	   	  
               	   	   $html.=  "<h5>".Yii::t("default","Sides")." :</h5>";
               	   	   foreach ($item['multi_id'] as $val_multi_id) {               	   	   	  
               	   	   	  if (array_key_exists($val_multi_id,(array)$multi_opt)){
               	   	   	  	  $html.=  "<p class=\"multi_option_item\">- ".$multi_opt[$val_multi_id]."</p>";
               	   	   	  }               	   	   
               	   	   }
               	   }               
               }    		
               /*MULTI ITEM*/
               
               if ($addon!=FALSE){                	   
               	   foreach ($addon as $addon_val) {                       
                       $addon_item[$addon_val->subcat_id]['item'][]=$addon_val->item[0];    		
                   }
               }
               
               if (!isset($addon_item)){
               	   $addon_item=''; 
               }
    		
               //dump($addon_item);               
               if (is_array($addon_item) && count($addon_item)>=1){
	               $html.=  "<div class=\"addon_wrap\">";
	               foreach ($addon_item as $key_val=>$val_item) { 	               	   
	               	   $discount='';
	               	   if ($category=yii::app()->functions->getSubcategoryById($key_val)){	               	   	   
	               	   	   $discount=empty($category[0]['discount'])?"":$category[0]['discount'];
	               	   }	               	   	               	 
	               	   if (in_array($key_val,(array)$subcategory_list)) {
	               	   	   $html.=  "<h5>".$subcategory_list[$key_val]."</h5>";
	               	   }	               	               	   
	               	   if (is_array($val_item['item']) && count($val_item['item'])>=1):
	               	   $total_addon=0;
	               	   foreach ($val_item['item'] as $val_sub_item):
	               	       $total_addon+=str_replace(",","",$val_sub_item->price);
			               $html.=  "<p>".$subcategory_item[$val_sub_item->addon_id]['sub_item_name'].
			               " (".baseCurr().prettyPrice($val_sub_item->price).") </p>";            
		               endforeach;              		
		               endif;  
		               //dump("total addon: ".$total_addon);		               		               
		               $discounted_amount=0;		               
		               if (!empty($discount)){
		               	   if (preg_match("/%/i", $discount)) {
		               	      $discounted_amount=preg_replace('/\D/', '', $discount);
		               	      if(is_numeric($discounted_amount)){
		               	      	 $discounted_amount=$discounted_amount/100;
		               	      	 $temp=($total_addon*$discounted_amount);
		               	      	 $discounted_amount=$total_addon-$temp; 
		               	      	 if (is_numeric($discounted_amount)){		               	      	 	
		               	      	 	$discounted_amount=number_format($discounted_amount,2);
		               	      	 }
		               	      }
		                   } else {		                   	  
		                   	  $discounted_amount=$discount;               	  
		                   }
		                   //$html.="discount amt:".$discounted_amount;
		                   if (preg_match("/%/i", $discount)) {
		                   	$html.="<p class=\"discount\"><span>* ".Yii::t("default","Discount")." $discount </span> ($discounted_amount)</p>";
		                   } else{
	                          $html.="<p class=\"discount\"><span>* ".Yii::t("default","Discount")." </span> ($discounted_amount)</p>";	                   	
		                   }		                   
		               }
		               $total_addon=$total_addon-$discounted_amount;
		               $html.="<addonsub_total>".Yii::t("default","Add On Sub Total").":".baseCurr().prettyPrice($total_addon)."</addonsub_total>";
		               $addon_total+=$total_addon;
		               $total_addon=0;
	               }          
	               $html.=  "</div>"; /*END addon_wrap*/
	               unset($addon);
	               unset($addon_item);
               }
                                             
               $item['item_price']=str_replace(",","",$item['item_price']);
               $item_price=$qty*$item['item_price'];               
               
               $item_price_with_discount=0;
               if (is_numeric($food_item_discount)){
               	   $item_price_with_discount=$item_price-$food_item_discount;
               	   $item_total+=$item_price_with_discount;
               } else {
               	   $item_total+=$item_price;               	   
               }
               
               $html.=  "</div>";
			   $html.=  "<div class=\"price_details\">";
			   $html.=  "<price>".baseCurr().prettyPrice($item_price)."</price>";
			   if (!empty($food_item_discount)){
			   	   $html.=  "<p>(".prettyPrice($food_item_discount).")</p>";
			   	   $html.=  "<p>".prettyPrice($item_price_with_discount)."</p>";			   	   
			   }			   
			   $html.= "<a href=\"".Yii::app()->request->baseUrl."/store/food-order/?item-id=".$item['item_id']."&row=".$item_key."\" class=\"glyphicon glyphicon-edit item_edit\"></a>";
			   $html.=  "<a href=\"javascript:;\" class=\"glyphicon glyphicon-trash item_remove\" rev=\"$item_key\" ></a>";			   
			   $html.=  "</div>";
			   $html.=  "<div class=\"clear\"></div>";	    
	    	   $html.="</li>";  	    	   	    	   
    		}      		
    		//$html.="</ul>";    
    		    		    	
    		$convenience_charge=yii::app()->functions->getOption("convenience_charge");		    		    		
    		$grand_total=$addon_total+$item_total;    	
    		
    		$temp_less_percentage=0;
    		if (isset($voucher_code_amt) && is_numeric($voucher_code_amt)){
    			if ( $voucher_type=="percentage"){
    				$temp_less_percentage=$grand_total*($voucher_code_amt/100);    				
    				$grand_total=$grand_total-$temp_less_percentage;
    			} else $grand_total=$grand_total-$voucher_code_amt;    			
    		}    	
    		    		
    		$tax=yii::app()->functions->getOption("tax_amount");    		
    		$tax_amt=0;
    		if (!empty($tax)){    	
    			$tgrand_total=$grand_total+$convenience_charge;
    			//dump($tgrand_total);
    			$tax_amt=$tgrand_total*($tax/100);
    			if (is_numeric($tax_amt)){
    				$tax_amt=number_format($tax_amt,2);
    			}
    		}    		
    		$grand_total_after_tax=$grand_total+$tax_amt+$convenience_charge;
    		
    		$complex_data='';
    		    		    		
    		//$html.="<grand_total><i>".Yii::t("default","Total")." :</i><span>".baseCurr().prettyPrice($item_total)."</span></grand_total>";
    		$html.="<grand_total><i>".Yii::t("default","Add on Items")." :</i><span>".baseCurr().prettyPrice($addon_total)."</span></grand_total>";
    		
    		$complex_data['tax']=$tax;
    		$complex_data['total']=$item_total;
    		$complex_data['total_addon']=$addon_total;
    		$complex_data['less_voucher']=$voucher_code_amt;
    		$complex_data['convenience_charge']=$convenience_charge;
    		
    		if (!empty($voucher_code)){
    			if ( $voucher_type=="percentage"){
    				$html.="<grand_total><i>".Yii::t("default","Less Discount Code")." ".$voucher_code_amt."% :</i><span>- (".baseCurr().prettyPrice($temp_less_percentage).")</span></grand_total>";
    			} else {
    		        $html.="<grand_total><i>".Yii::t("default","Less Discount Code")." :</i><span>- (".baseCurr().prettyPrice($voucher_code_amt).")</span></grand_total>";
    			}
    		}    
    		
    		$html.="<grand_total><i>".Yii::t("default","Sub Total")." :</i><span>".baseCurr().prettyPrice($grand_total)."</span></grand_total>";
    		    		
    		if ($convenience_charge>0){
    			$html.="<grand_total><i>".Yii::t("default","Convenience Charge")." :</i><span>".baseCurr().prettyPrice($convenience_charge)."</span></grand_total>";
    		}    	
    		    		    		    	
    		if ($tax<=0){
    			
    			$html.="<div class=\"line-sep\"></div>";
    		    $html.="<grand_total class=\"metotal\"><i>".Yii::t("default","Total")." :</i><span>".baseCurr().prettyPrice($grand_total)."</span></grand_total>";
    		    $html.="<span class=\"min_total_order\">".unPrettyPrice($grand_total_after_tax)."</span>";
    		    $_SESSION['min_total_order']=unPrettyPrice($grand_total_after_tax);
    		} else {        			
    		    $html.="<grand_total><i>".Yii::t("default","Tax")." $tax %:</i><span>".prettyPrice($tax_amt)."</span></grand_total>";
    		    $html.="<div class=\"line-sep\"></div>";
    		    $html.="<grand_total class=\"metotal\"><i>".Yii::t("default","Total")." :</i><span>".baseCurr().prettyPrice($grand_total_after_tax)."</span></grand_total>";
    		    $html.="<span class=\"min_total_order\">".unPrettyPrice($grand_total)."</span>";
    		    $_SESSION['min_total_order']=unPrettyPrice($grand_total_after_tax);
    		}
    		$html.="<div class=\"clear\"></div>";
    		    		
    		    		    		
    		
    		$this->code=1;
    		$this->msg="OK";
    		$this->details=array(
    		 'item'=>count($_SESSION[KARENDERIA]['item']),
    		 'html'=>$html,
    		 'complex_data'=>$complex_data
    		);    		
    	} else $this->msg=Yii::t("default","Cart is empty");
    }
    
    public function removeAddonitemAjax()
    {    	       	    	    	    	
    	if (array_key_exists($this->data['row'], (array) $_SESSION[KARENDERIA]['item'] )){
    	    //unset( $_SESSION[KARENDERIA]['item'][$this->data[row]+0] );
    	    unset($_SESSION[KARENDERIA]['item'][$this->data['row']]);
    	}
    	$this->code=1;
    	$this->msg=Yii::t("default","OK");
    }
    
    public function formDelivery()
    {
    	$_SESSION['delivery_date']='';
    	$_SESSION['delivery_time']='';
    	
    	//dump($this->data);
    	$continue=true;    	
    	if ($this->data['trans_type']=="delivery"){
	    	$delivery_distance=yii::app()->functions->getOption('delivery_distance');
	    	if (is_numeric($delivery_distance)){
	    		$from=yii::app()->functions->getOption('address');
	    		if ($distance=getDistance($from,$this->data['delivery_address'])){ 	    			
	    			$distance_=$distance->rows[0]->elements[0]->distance->text;	    			
	    			//$distance=preg_replace('/\D/', '', $distance_);
	    			$distance=(float)str_replace(array(" ","km"),"",$distance_);   	    			
	    			if (is_numeric($distance)){    				
	    				if ($distance>$delivery_distance){
	    					if (preg_match("/km/i", $distance_)) {
	    					    $this->msg=Yii::t("default","Sorry but we cannot deliver that far. Your delivery address seems exceeded our delivery covered area.");
	    					    $continue=false;	
	    					}    					
	    				} 
	    			} else $this->msg=Yii::t("default","Sorry but we cannot find or locate your address.");    		
	    		} else $this->msg=Yii::t("default","Sorry but we cannot find or locate your address.");    		
	    	}    	
    	}
    	
    	if (yii::app()->functions->accountExist($this->data['email'])){  
    		$this->msg=Yii::t("default","Sorry but your email address is already exist in our records")."\n"; 
    		$continue=false;
    	}
    	if (!empty($this->msg)){
    		$continue=false;
    	}    	
    	if ($continue==TRUE){    		
    		    		    		
    		if (!isset($this->data['delivery_address'])){
    			$this->data['delivery_address']='';
    		}    	
    		if (!isset($this->data['delivery_instruction'])){
    			$this->data['delivery_instruction']='';
    		}    	
    		if (!isset($this->data['location_name'])){
    			$this->data['location_name']='';
    		}    	
    		
			if (!isset($this->data['delivery_date'])){
				$this->data['delivery_date']="";
			}
			if (!isset($this->data['delivery_time'])){
				$this->data['delivery_time']="";
			}    		
			
			$_SESSION['delivery_date']=$this->data['delivery_date'];
    	    $_SESSION['delivery_time']=$this->data['delivery_time'];
    	    $_SESSION['delivery_asap']=$this->data['delivery_asap'];
    		    	    
    		$params=array(
    		  'fullname'=>$this->data['fullname'],
    		  //'phone'=>$this->data['phone'],
    		  'mobile'=>$this->data['mobile'],
    		  'email'=>$this->data['email'],
    		  'password'=>md5($this->data['password']),
    		  'delivery_address'=>$this->data['delivery_address'],
    		  'delivery_instruction'=>$this->data['delivery_instruction'],
    		  'location_name'=>$this->data['location_name'],
    		  'date_created'=>date('c'),
    		  'ip_address'=>$_SERVER['REMOTE_ADDR'],
    		  'delivery_date'=>$this->data['delivery_date'],
              'delivery_time'=>$this->data['delivery_time']			    
    		);    	    		
    		$command = Yii::app()->db->createCommand();
    		if ($res=$command->insert('{{client}}',$params)){
                $this->code=1;
                $this->msg=Yii::t("default",'Information has been saved.');
                $client_id=Yii::app()->db->getLastInsertID();
                //$this->details=$this->save_order($client_id);
                //unset($_SESSION[KARENDERIA]);                
                
                /*AUTO LOGIN*/	            
	            $this->data['username']=$this->data['email'];
	            $this->data['password']=$this->data['password'];
	            $this->login();
                
	        } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
    	}
    }
    
    public function signUp()
    {
    	$continue=TRUE;
    	if (yii::app()->functions->accountExist($this->data['email'])){  
    		$this->msg=Yii::t("default","Sorry but your email address is already exist in our records")."\n";    		
    		$continue=false;
    	}    	    	
    	if ($continue==TRUE){
		    $params=array(
			  'fullname'=>$this->data['fullname'],
			  //'phone'=>$this->data['phone'],
			  'mobile'=>$this->data['mobile'],
			  'email'=>$this->data['email'],
			  'password'=>md5($this->data['password']),		  
			  'date_created'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR'] 
			);
			$command = Yii::app()->db->createCommand();
			if ($res=$command->insert('{{client}}',$params)){
	            $this->code=1;
	            $this->msg=Yii::t("default",'Information has been saved.');    
	            
	            /*AUTO LOGIN*/	            
	            $this->data['username']=$this->data['email'];
	            $this->data['password']=$this->data['password'];
	            $this->login();
	            
	        } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
    	}
    }
    
    public function saveOrder($client_id='',$transtype='delivery',$payment_type='cash-on-delivery',$cc_id='')
    {
    	$command = Yii::app()->db->createCommand();   
    	if (isset($_SESSION[KARENDERIA]['item'])){
	    	if (is_array($_SESSION[KARENDERIA]['item']) && count($_SESSION[KARENDERIA]['item'])>=1){
	    		
	    		$params['json_order_details']=json_encode($_SESSION[KARENDERIA]);
	    		$params['date_created']=date('c');
	    		$params['client_id']=$client_id;
	    		$params['ip_address']=$_SERVER['REMOTE_ADDR']; 
	    		$params['trans_type']=$transtype;
	    		$params['payment_type']=$payment_type;
	    		
	    		$voucher_code=isset($_SESSION['temp_voucher_code'])?$_SESSION['temp_voucher_code']:"";
                $voucher_code_amt=isset($_SESSION['temp_voucher_amount'])?$_SESSION['temp_voucher_amount']:"";
                $voucher_type=isset($_SESSION['temp_voucher_type'])?$_SESSION['temp_voucher_type']:"";
	    		
	    		$params['voucher_code']=$voucher_code;
	    		$params['voucher_amount']=$voucher_code_amt;
	    		$params['voucher_type']=$voucher_type;	  
	    			    		
	    		$params['delivery_asap']=isset($_SESSION['delivery_asap'])?$_SESSION['delivery_asap']:1;
	    		
	    		if ( !empty($cc_id)){
	    			$params['cc_id']=$cc_id;
	    		}	    	
	    			    		
	    		if (isset($_SESSION['delivery_date'])){
	    			if (!empty($_SESSION['delivery_date'])){
	    				$params['delivery_date']=$_SESSION['delivery_date'];
	    			}
	    		}	    		
	    		if (isset($_SESSION['delivery_time'])){
	    			if (!empty($_SESSION['delivery_time'])){
	    				$params['delivery_time']=$_SESSION['delivery_time'];
	    			}
	    		}
	    			    		
                $stats_id=Yii::app()->functions->getOption("stats_id");
	            if (!empty($stats_id)){
	                $params['stats_id']=Yii::app()->functions->getOption("stats_id");
	            } else $params['stats_id']=1;	            
	            
	            $convenience_charge=yii::app()->functions->getOption("convenience_charge");	
	            if ( $convenience_charge>0){
	            	$params['convenience_charge']=$convenience_charge;
	            }	    	
	            	    		
	    		$command->insert('{{order}}',$params);
	    		$order_id=Yii::app()->db->getLastInsertID();
	    		
	    		foreach ($_SESSION[KARENDERIA]['item'] as $item) {
	    			$food_item=yii::app()->functions->getFoodItemDetails($item['item_id']);      			
	    			$insert='';    			
	    			$insert['item_id']=$item['item_id'];
	    			$insert['item_name']=$food_item[0]['item_name']; 
	    			$insert['item_size']=$item['item_size'];
	    			$insert['order_notes']=isset($item['order_notes'])?$item['order_notes']:"";
	    			$insert['item_price']=$item['item_price'];
	    			$insert['qty']=$item['qty'];
	    			$insert['cooking_ref']=$item['cooking_ref'];
	    			$insert['addon']=$item['addon'];
	    			$insert['order_id']=$order_id;
	    			$insert['client_id']=$client_id;  
	    			$insert['multi_id']=isset($item['multi_id'])?json_encode($item['multi_id']):"";	    			
	    			$command->insert('{{order_details}}',$insert);
	    		}    
	    			    			    		
	    		if ( $payment_type=="paypal"){
	    			
	    		} else {	    		    		
		    		unset($_SESSION[KARENDERIA]['item']);    		
		    		unset($_SESSION['temp_voucher_code']);
	                unset($_SESSION['temp_voucher_amount']);
	    		}

                /*UPDATE VOUCHER */               
                if (!empty($voucher_code)){
                	$DbExt=new DbExt;
                	$DbExt->updateData("{{voucher_list}}",
                	array(
	                	'client_id'=>$client_id,
	                	'status'=>"used",
	                	'date_used'=>date('c'),
	                	'order_id'=>$order_id
                	)
                	,'voucher_code',$voucher_code);
                }
                
	    		return $order_id;		
	    	}
    	}
    	return false;
    }
    
    public function login()
    {    	    	
    	if (!isset($this->data['password_md5'])){
    		$this->data['password_md5']=true;
    	}
    	if ($res=Yii::app()->functions->login($this->data['username'],$this->data['password'],$this->data['password_md5']) ){
    		$this->code=1;
    		$this->msg=Yii::t("default","Login Successful");
    		$this->details=$res[0]['client_id'];
    		$_SESSION[KARENDERIA]['login']=1;
    		$_SESSION[KARENDERIA]['user_info']=$res[0];
    	} else $this->msg=Yii::t("default","Login Failed. Either username or password are invalid.");
    }
    
    public function formDeliveryUpdate()
    {
    	$continue=TRUE;
    	$_SESSION['delivery_date']='';
    	$_SESSION['delivery_time']='';
    
    	$delivery_distance=yii::app()->functions->getOption('delivery_distance');
    	if (is_numeric($delivery_distance)){
    		$from=yii::app()->functions->getOption('address');
    		if ($distance=getDistance($from,$this->data['delivery_address'])){     			
    			$distance_=$distance->rows[0]->elements[0]->distance->text;
    			//$distance=preg_replace('/\D/', '', $distance_);
    			//$distance=(integer)$distance_;      			
    			$distance=(float)str_replace(array(" ","km"),"",$distance_);     			
    			if (is_numeric($distance)){    				
    				if ($distance>$delivery_distance){
    					if (preg_match("/km/i", $distance_)) {
    					    $this->msg=Yii::t("default","Sorry but we cannot deliver that far. Your delivery address seems exceeded our delivery covered area.");
    					    $continue=false;	
    					}    					
    				} 
    			} else $this->msg=Yii::t("default","Sorry but we cannot find or locate your address.");    		
    		} else $this->msg=Yii::t("default","Sorry but we cannot find or locate your address.");    		
    	}    	
    	    	
    	if (!empty($this->msg)){
    		$continue=false;
    	}
    	if ($continue==TRUE){    		
    		if ($client_id=Yii::app()->functions->userId()){    
    			    			
    			if (!isset($this->data['delivery_date'])){
    				$this->data['delivery_date']="";
    			}
    			if (!isset($this->data['delivery_time'])){
    				$this->data['delivery_time']="";
    			}    			
    			    			    			
    			$_SESSION['delivery_date']=$this->data['delivery_date'];
    			$_SESSION['delivery_time']=$this->data['delivery_time'];
    			$_SESSION['delivery_asap']=$this->data['delivery_asap'];
    			
    		    $params=array(
    		      'delivery_address'=>$this->data['delivery_address'],
    		      'delivery_instruction'=>$this->data['delivery_instruction'],
    		      'location_name'=>$this->data['location_name'],
    		      'delivery_date'=>$this->data['delivery_date'],
    		      'delivery_time'=>$this->data['delivery_time']
    		    );    	
    		    
    		    $command = Yii::app()->db->createCommand();
    		    try {
    		       $up = $command->update('{{client}}' , $params , 
				   'client_id=:client_id' , array(':client_id'=> addslashes($client_id) ));					
				   
				   $this->code=1;
                   $this->msg='Order has been place.';                   
                   //$this->details=$this->saveOrder($client_id);				   
    		    } catch (Exception $e){
    		        $this->msg= 'Caught exception: '. $e->getMessage(). "\n";
    		    }    		    
    		} else $this->msg=Yii::t("default","ERROR: Sorry but your session has expired try to login.");
    	}
    }
    
    public function addToWishlist()
    {    	
    	if (isset($this->data['item_id'])){
    		$params=array(
    		  'client_id'=>addslashes(Yii::app()->functions->userId()),
    		  'item_id'=>addslashes($this->data['item_id']),
    		  'date_created'=>date('c'),
    		  'ip_address'=>$_SERVER['REMOTE_ADDR']
    		);
    		$command = Yii::app()->db->createCommand();
    		if ($res=$command->insert('{{client_wishlist}}',$params)){
                $this->code=1;
                $this->msg='OK';
	        } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
    	} else $this->msg=Yii::t("default","ERROR: sorry we cannot saved your wishlist right now. please try again later.");    
    }
    
    public function loadWishlist()
    {
        $stmt="
		SELECT a.*,
		(
		select item_name from {{item}}
		where item_id=a.item_id
		) as item_name
		 FROM
		{{client_wishlist}} a
		WHERE client_id='".addslashes(Yii::app()->functions->userId())."'
		ORDER BY id DESC
		LIMIT 0,100
		";       
		$connection=Yii::app()->db;
    	$rows=$connection->createCommand($stmt)->queryAll(); 
    	if (is_array($rows) && count($rows)>=1){    		
    		$htm='';    		
    		foreach ($rows as $value) {
    			$link=Yii::app()->request->baseUrl."/store/food-order/?item-id=".$value['item_id'];
    			$htm.="<div class=\"wr_$value[id]\">";
    			$htm.="<a href=\"$link\" class=\"left\"><span class=\"glyphicon glyphicon-heart-empty\"></span>".$value['item_name']."</a>";
    			$htm.="<a href=\"javascript:;\" rev=\"$value[id]\" class=\"wishlist_remove right\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
    			$htm.="</div>";    			
    		}
    		$this->code=1;
    		$this->msg=count($rows);
    		$this->details=$htm;
    	} else $this->msg=Yii::t("default","Your Wishlist is empty");
    }
    
    public function removeWishtlist()
    {    	
    	if (isset($this->data['id'])){
    		$command = Yii::app()->db->createCommand();
    		Yii::app()->db->createCommand("
    		DELETE FROM {{client_wishlist}} WHERE id='".
    		addslashes($this->data['id'])."' ")->query();
    		$this->code=1;
    		$this->msg="OK";
    	} else $this->msg=Yii::t("default","ERROR: Something went wrong.");
    }
    
    public function recentOrderToCart()
    {
    	yii::app()->functions->sessionInit();
    	$stmt="
		SELECT * FROM
		{{order}}
		WHERE
		order_id ='".addslashes($this->data['id'])."'				
		LIMIT 0,1
		";				
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 						
		if (is_array($rows) && count($rows)>=1){
			 $order=!empty($rows[0]['json_order_details'])?json_decode($rows[0]['json_order_details']):false;
			 $order_item='';
			 if (is_array($order->item) && count($order->item)>=1){
			     foreach ($order->item as $val) {			     	
			     	$order_item[]=(array)$val;
			     	$_SESSION[KARENDERIA]['item'][]=(array)$val;
			     }			     
			     //$_SESSION[KARENDERIA]['item']=$order_item;
			     $this->code=1;
			     $this->msg=Yii::t("default","Your order has been added to your cart.");
			 } else $this->msg=Yii::t("default","ERROR: sorry but we cannot process your request.");
		} else $this->msg=Yii::t("default","ERROR: sorry but we cannot find your order id.");
    }
    
    public function loadRecentOrder()
    {       
       Yii::app()->functions->recentOrderWidget();
       die();
    }
    
    public function paypalCheckoutPayment()
    {
    	if (!empty($this->data['payerid']) && !empty($this->data['payerid'])){
    	   $paypal_con=Yii::app()->functions->getPaypalConnection();      	   
           $paypal=new Paypal($paypal_con);	
           $paypal->params['PAYERID']=$this->data['payerid'];
           $paypal->params['AMT']=$this->data['amount'];   
           $paypal->params['TOKEN']=$this->data['token'];     
           $paypal->params['CURRENCYCODE']=yii::app()->functions->getCurrencyCodes();
                 
           if ($res=$paypal->expressCheckout()){            	              	   
           	   $this->code=1;
           	   $this->msg=Yii::t("default","Your purchase has been place.");
           	   $this->details=array(
           	     'order_id'=>$this->data['order_id'],
           	     'token'=>$this->data['token']           	     
           	   );           	   
           	   
           	   $params=array('status'=>addslashes($res['ACK']));
		       $command = Yii::app()->db->createCommand();
		       $command->update('{{paypal_checkout}}' , $params , 
				                     'token=:token' , array(':token'=> addslashes($this->data['token']) ));
				                     
			   $params=array('status'=>'paid');		       
		       $command->update('{{order}}' , $params , 
				                     'order_id=:order_id' , array(':order_id'=> addslashes($this->data['order_id']) ));
              
           	   $db_ext=new DbExt;
           	   $insert=array(
           	     'order_id'=>$this->data['order_id'],
           	     'TOKEN'=>$this->data['token'],
		         'TRANSACTIONID'=>$res['TRANSACTIONID'],
		    	 'TRANSACTIONTYPE'=>$res['TRANSACTIONTYPE'],
		    	 'PAYMENTTYPE'=>$res['PAYMENTTYPE'],
		    	 'ORDERTIME'=>$res['ORDERTIME'],
		    	 'AMT'=>$res['AMT'],
		    	 'FEEAMT'=>!isset($res['FEEAMT'])?0:$res['FEEAMT'],
		    	 'TAXAMT'=>$res['TAXAMT'],
		    	 'CURRENCYCODE'=>$res['CURRENCYCODE'],
		    	 'PAYMENTSTATUS'=>$res['PAYMENTSTATUS'],
		    	 'CORRELATIONID'=>$res['CORRELATIONID'],
		    	 'TIMESTAMP'=>$res['TIMESTAMP'],
		    	 'json_details'=>json_encode($res),
		    	 'date_created'=>date('c'),
		    	 'ip_address'=>$_SERVER['REMOTE_ADDR']
           	   );
           	   $db_ext->insertData("{{paypal_payment}}",$insert);           	   
           	   
           } else $this->msg=$paypal->getError();
    	} else $this->msg=Yii::t("default","ERROR: One or more field is missing.");
    }
    
    public function fbRegister()
    {
    	//dump($this->data);
    	if (isset($this->data['email'])){
    		$params=array(
    		  'fullname'=>addslashes($this->data['name']),
    		  'email'=>addslashes($this->data['email']),
    		  'social_strategy'=>'fb',
    		  'password'=>md5(addslashes($this->data['id'])),
    		  'date_created'=>date('c'),
    		  'ip_address'=>$_SERVER['REMOTE_ADDR']    		
    		);    		
    		if ($social_info=yii::app()->functions->accountExistSocial($this->data['email'])){      		    
    		    /*AUTO LOGIN*/	            
	            $this->data['username']=addslashes($this->data['email']);
	            $this->data['password']=addslashes($social_info[0]['password']);
	            $this->data['password_md5']=false;
	            $this->login();
    	    } else {   	    	    	    
    		$command = Yii::app()->db->createCommand();
				if ($res=$command->insert('{{client}}',$params)){
		            $this->code=1;
		            $this->msg=Yii::t("default",'Information has been saved.');    
		            
		            /*AUTO LOGIN*/	            
		            $this->data['username']=addslashes($this->data['email']);
		            $this->data['password']=addslashes($this->data['id']);
		            $this->login();
		            
		        } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
    	    }
    	} else $this->msg=Yii::t("default","Unexpected response. please login again.");
    }
    
    public function updateProfile()
    {
    	//dump($this->data);    	
    	$params=array(
    	  'fullname'=>$this->data['fullname'],
    	  //'phone'=>$this->data['phone'],
    	  'mobile'=>$this->data['mobile'],
    	  'email'=>$this->data['email'],
    	  'delivery_address'=>$this->data['delivery_address'],
    	  'date_modified'=>date('c'),
    	  'ip_address'=>$_SERVER['REMOTE_ADDR']
    	);
    	$cont=true;
    	if (!empty($this->data['old_password']) && !empty($this->data['new_password'])){
    		if (!Yii::app()->functions->verifyPassword($this->data['old_password'])){
    			$cont=false;
    		} else $params['password']=md5($this->data['new_password']);
    	}    	
    	if ($cont){
	    	$db_ext=new DbExt;
	    	if ($db_ext->updateData("{{client}}",$params,'client_id',Yii::app()->functions->userId())){
	    		$this->code=1;
	    		$this->msg=Yii::t("default","Profile saved.");
	    	} else $this->msg=Yii::t("default","ERROR: cannot update profile.");    
    	} else $this->msg=Yii::t("default","Old password does not match");
    	
    }
    
    public function contactForm()
    {    	    	
    	unset($this->data['action']);
    	foreach ($this->data as $key=>$val) {    		
    	    //$required[$key]=ucwords($key). Yii::t("default"," is required");
    	    $required[$key]=Yii::t("default",ucwords($key)." is required");
    	}    	
    	
    	$validator=new Validator;
    	$validator->required($required,$this->data);
    	if ($validator->validate()){    		
    		
    		$tpl="<p>".Yii::t("default","Hi admin")."</p>";
    		$tpl.="<p>".Yii::t("default","There is someone fill the contact form")."<p>";
    		$tpl.="<p>".Yii::t("default","see below information")."<p>";
    		foreach ($this->data as $key=>$val) {    		
    			$tpl.=ucwords($key)." : $val<br/>";
    		}    		
    		    		
    		$to=yii::app()->functions->getOption('contact_email_receiver');
    		
    		$from=yii::app()->functions->getOption('receipt_from_email');
			if (empty($from)){
				$from='no-reply@'.$_SERVER['HTTP_HOST'];
			}
    		
    		$subject=Yii::t("default","New Contact Us");
    		
    		$email_engine=yii::app()->functions->getOption('email_engine');
    		    		    		
    		if ( $email_engine == 1){
	    		if (Yii::app()->functions->sendEmail($to,$from,$subject,$tpl)){
	    			$this->code=1;    		
	    		    $this->msg=Yii::t("default","Your message was sent successfully. Thanks.");
	    		} else $this->msg=Yii::t("default","ERROR: Cannot sent email.");
    		} else {    			
    			if (Yii::app()->functions->sendEmailSMTP($to,$from,$subject,$tpl)){
	    			$this->code=1;    		
	    		    $this->msg=Yii::t("default","Your message was sent successfully. Thanks.");
	    		} else $this->msg=Yii::t("default","ERROR: Cannot sent email.");
    		}
    		
    	} else $this->msg=$validator->getErrorAsHTML();
    }
    
    public function reservationSaved()
    {
    	//dump($this->data);
    	$required=array(
    	  'client_name'=>Yii::t("default","Name is required"),
    	  'phone_number'=>Yii::t("default","Phone is required"),
    	  'email_address'=>Yii::t("default","Email address is required"),
    	  'number_of_person'=>Yii::t("default","Number of person is required"),
    	  'reservation_date'=>Yii::t("default","Reservation date is required"),
    	  'reservation_time'=>Yii::t("default","Reservation time is required"),
    	  'message'=>Yii::t("default","Message is required")
    	);
    	
    	$validator=new Validator;
    	$validator->required($required,$this->data);
    	if ($validator->validate()){    		    		
    		$EmailTemplate=new EmailTemplate;
    		$tpl=$EmailTemplate->reservationTemplate();    		
    		$tpl=Yii::app()->functions->smarty("client_name",$this->data['client_name'],$tpl);
    		$tpl=Yii::app()->functions->smarty("phone_number",$this->data['phone_number'],$tpl);
    		$tpl=Yii::app()->functions->smarty("email_address",$this->data['email_address'],$tpl);
    		$tpl=Yii::app()->functions->smarty("number_of_person",$this->data['number_of_person'],$tpl);
    		$tpl=Yii::app()->functions->smarty("reservation_date",$this->data['reservation_date'],$tpl);
    		$tpl=Yii::app()->functions->smarty("reservation_time",$this->data['reservation_time'],$tpl);
    		$tpl=Yii::app()->functions->smarty("message",$this->data['message'],$tpl);
    		
    		$send_to=Yii::app()->functions->getOption('reservation_to_email');    	
		    $from=yii::app()->functions->getOption('receipt_from_email');
		    $subject=yii::app()->functions->getOption('reservation_subject');
		    $email_engine=yii::app()->functions->getOption('email_engine');
		    if (empty($subject)){
		    	$subject=Yii::t("default","New Reservation");
		    }    
		    if (empty($from)){
			    $from='no-reply@'.$_SERVER['HTTP_HOST'];
		    } 				    
		    
		    if ( !empty($send_to) ){
		    	if ( $email_engine == 2){				
				    if (Yii::app()->functions->sendEmailSMTP($send_to,$from,$subject,$tpl) ){				
				    }
				} else {				
				   if (Yii::app()->functions->sendEmail($send_to,$from,$subject,$tpl) ){		
				   }
				}
		    }    	
		    $this->code=1;
		    $this->msg=Yii::t("default","Your Request was sent successfully. Thank you.");
    	} else $this->msg=$validator->getErrorAsHTML();	
    }
    
    public function processDiscount()
    {    	    	
    	if (isset($this->data['voucher_code'])){
    		if (!empty($this->data['voucher_code'])){
    			if ( $res=Yii::app()->functions->getVoucherCodeActive($this->data['voucher_code']) ){       				
    				if ( $res['status']=="publish"){
    					if ($res['total_used']<=0){
    						$this->code=1;
    						$this->msg="Successful";
    						$this->details=$res['amount'];    						
    						$_SESSION['temp_voucher_code']=$this->data['voucher_code'];
    						$_SESSION['temp_voucher_amount']=$res['amount'];
    						$_SESSION['temp_voucher_type']=$res['voucher_type'];
    					} else $this->msg=Yii::t("default","Voucher code has been used.");
    				} else $this->msg=Yii::t("default","Voucher code has expired.");
    			} else $this->msg=Yii::t("default","Voucher code not found.");    		
    		} else $this->msg=Yii::t("default","Voucher code is required");    
    	} else $this->msg=Yii::t("default","Voucher code is required");    
    }
    
    public function popUpItem()
    {	   
	   require_once 'pop-item.php';
	   die();
    }
    
    public function removeVoucher()
    {
    	unset($_SESSION['temp_voucher_code']);
        unset($_SESSION['temp_voucher_amount']);
        $this->code=1;
        $this->msg="OK";
    }
    
    public function addCreditCard()
    {    
    	$params=$this->data;
    	unset($params['action']);
    	$params['client_id']=Yii::app()->functions->userId();
    	$params['date_created']=date('c');
    	$params['ip_address']=$_SERVER['REMOTE_ADDR'];    	
    	
    	$cc=new Validate_Finance_CreditCard;    	
    	if ( !$cc->number($this->data['credit_card_number'])){
    		$this->msg="Invalid Card number";
    		return ;
    	}    
    	$DbExt=new DbExt;    	
    	if ( $DbExt->insertData("{{client_cc}}",$params)){
    	    $this->code=1;
    	    $this->msg=Yii::t("default","Card successfuly added.");
    	} else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
    }
    
    public function loadCreditCard()
    {
    	$data='';
    	$DbExt=new DbExt;   
    	$stmt="SELECT * FROM
    	{{client_cc}}
    	WHERE
    	client_id='".Yii::app()->functions->userId()."'
    	ORDER BY cc_id DESC    	
    	";
    	if ( $res=$DbExt->rst($stmt)){
    		foreach ($res as $val) {
    			$data[]=array(
    			  'cc_id'=>$val['cc_id'],
    			  'credit_card_number'=>Yii::app()->functions->maskCardnumber($val['credit_card_number'])
    			);
    		}    		
    		$this->code=1;
    		$this->details=$data;
    	} else $this->msg=Yii::t("default","No card yet");
    }
    
    public function addPayment()
    {
    	
		$trans_type='delivery';
		if (isset($this->data['trans_type'])){
			if (!empty($this->data['trans_type'])){
			   $trans_type=$this->data['trans_type'];
			}
		}
				
		$continue=false;
		
		$minimum_order=yii::app()->functions->getOption('minimum_order');
		$min_total_order=isset($_SESSION['min_total_order'])?$_SESSION['min_total_order']:"";
				
		if (!empty($minimum_order)){
			if ($minimum_order<=$min_total_order){
				$continue=TRUE;
			}
		} else $continue=true;
		
		if ( $continue==TRUE){
			 $order_id=$this->saveOrder(yii::app()->functions->userId(),$trans_type,'card',$this->data['cc_id']);             
             $this->code=1;
             
             /*pre order*/
			$enabled_preorder=Yii::app()->functions->getOption("enabled_preorder");			
			if ( $enabled_preorder==1){
				$this->msg=Yii::t("default","Redirecting to order verification");
				$this->details=Yii::app()->request->baseUrl."/store/preOrder/order_id/".$order_id;
			} else {
               $this->msg=Yii::t("default","Your Order has been placed.");
               $this->details=Yii::app()->request->baseUrl."/store/receipt/order_id/".$order_id;
			}
		} else {
			$this->msg=Yii::t("default","Sorry the minimum order amount is ").baseCurr().prettyPrice($minimum_order);			
		}
    }

    public function getPreOrderStatus()
    {        
        $order_id=isset($this->data['order_id'])?$this->data['order_id']:'';
        if ( $res=Yii::app()->functions->getPreApprovedSatus($order_id)){        	        	
        	if ( $res['pre_approved']==1){
        		$this->code=1;
        		$msg_time=yii::t("default","Delivery time : ").$res['pre_approved_time'];
        		$this->msg=Yii::t("default","Your order has been approved. ".$msg_time );
        		$this->details=$res['pre_approved_time'];
        	} elseif ($res['pre_approved']==2){
        		$this->code=3;
        		$this->msg=Yii::t("default","Sorry but your order has been rejected.");
        	} else $this->msg="No response yet from restaurant owner";
        } else $this->msg=Yii::t("default","Sorry but we cannot found your order.");    
    }	
    
    public function brainTreeInit()
	{		
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
        require_once $path."/create.php";         
    }
    
    public function forgotPassword()
    {    	
    	$DbExt=new DbExt;   
    	$stmt="SELECT * FROM
    	{{client}}
    	WHERE
    	email=".$this->q($this->data['email_address'])."
    	LIMIT 0,1
    	";
    	if ($res=$DbExt->rst($stmt)){
    		$client_email=$res[0]['email'];    		
    		$this->code=1;
    		$this->msg=t("Email was sent to your email address");
    		
    		$sender=Yii::app()->functions->getOption("forgot_sender");
    		$subject=Yii::app()->functions->getOption("forgot_subject");
    		$tpl=Yii::app()->functions->getOption("forgot_tpl");
    		    		    		
    		$reset_link=Yii::app()->getBaseUrl(true)."/store/resetpassword/?ref=".$res[0]['client_id']."&token=".$res[0]['password'];
    		
    		$tpl=Yii::app()->functions->smarty("customer-name",$res[0]['fullname'],$tpl);
    		$tpl=Yii::app()->functions->smarty("reset-password-link",$reset_link,$tpl);    		
    		    		
    		
    		$email_engine=yii::app()->functions->getOption('email_engine');    		
    		
    		if ( $email_engine == 2){				
				if (Yii::app()->functions->sendEmailSMTP($client_email,$sender,$subject,$tpl) ){				
			    }
			} else {				
			   if (Yii::app()->functions->sendEmail($client_email,$sender,$subject,$tpl) ){		
			   } 
			}    		    		
    	} else $this->msg=t("Sorry but your email address does not exist in our records");    
    }
    
    private function q($data='')
	{
		return Yii::app()->db->quoteValue($data);
	}
	
	public function resetPassword()
	{		
		$DbExt=new DbExt;   
		if ($this->data['new_pass']==$this->data['confirm_pass']){		
			$stmt="
			SELECT * FROM
			{{client}}
			WHERE
			client_id=".$this->q($this->data['ref'])."			
			AND	
			password=".$this->q($this->data['token'])."
			LIMIT 0,1
			";			
			if ( $res=$DbExt->rst($stmt)){				
				$client_id=$res[0]['client_id'];				
				$params=array(
				  'password'=>md5($this->data['new_pass'])
				);				
				if ( $DbExt->updateData("{{client}}",$params,'client_id',$client_id)){
					$this->code=1;
					$this->msg=t("Your password has been reset");
				} else $this->msg=t("ERROR: Failed updating password");			
			} else $this->msg=t("Sorry but we cannot find your referrence token");		
		} else $this->msg=t("Confirm password does not match");	
		
	}
	    
}
/*END CLASS*/

if (!function_exists('dump')){
	function dump($data='')
	{
		echo "<pre>";print_r($data);echo "</pre>";
	}
}