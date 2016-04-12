<?php
$amount_to_pay=0;
if ($amount_to_pay=getOrderCart("BrainTree",$this->data['trans_type'])){
	//dump($amount_to_pay);	
	try {
				
		$convenience_charge=yii::app()->functions->getOption("convenience_charge");
		
		if ( $convenience_charge>0){
			//$amount_to_pay=$amount_to_pay-$convenience_charge;
			$result = Braintree_Transaction::sale(array(
	           'amount' => prettyPrice($amount_to_pay),
	           'paymentMethodNonce' => $this->data['nonce'],
	           //'serviceFeeAmount'=>prettyPrice($convenience_charge)
	        ));	        		       
		} else {		
			$result = Braintree_Transaction::sale(array(
	          'amount' => prettyPrice($amount_to_pay),
	          'paymentMethodNonce' => $this->data['nonce']
	        ));	
		}		
								    
	    /*dump($result);
	    dump($result->success);
	    dump($result->transaction->id);*/
	    
	    if ( $result->success==1){
	    	
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
				 //$order_id=$this->saveOrder(yii::app()->functions->userId(),$trans_type,'BrainTree');             
				 $order_id=$this->saveOrder(yii::app()->functions->userId(),$trans_type,'creditcard');             
	             $this->code=1;
	             
	             /*insert logs*/
	             $db_ext=new DbExt;
	             $params_logs=array(
	               'order_id'=>$order_id,
	               'transaction_id'=>$result->transaction->id,
	               'json_data'=>json_encode((array)$result),
	               'date_created'=>date('c'),
	               'ip_address'=>$_SERVER['REMOTE_ADDR']
	             );
	             $db_ext->insertData("{{braintree_trans}}",$params_logs);
	             
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
	    } else $this->msg=Yii::t("default","ERROR:" . " ".$result->message);    
	
	} catch (Exception $e){
		$this->msg=$e;
	}
	
} else $this->msg=Yii::t("default","Amount to pay is empty");