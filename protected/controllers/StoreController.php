<?php
/**
 * Store Controller
 *
 */
if (!isset($_SESSION)) { session_start(); }

class StoreController extends CController
{
	public $layout='sites_tpl';	
	
	public function filters(){
		$app_name=yii::app()->functions->getOption('store_name');
		if ( !empty($app_name)){
			Yii::app()->name=yii::app()->functions->getOption('store_name');
		}		
	}
		
    public function missingAction($action_id) { 		
	    $action_id = explode('-', $action_id);
	    $action_id = array_map('strtolower', $action_id);
	    $action_id = array_map('ucfirst', $action_id);
	    $action_id = implode('', $action_id);
	    if (method_exists($this, 'action' . $action_id) || array_key_exists('action' . $action_id, $this->actions())) {
	        $this->setAction($action_id);
	        $this->run($action_id);
	    } else {
	        throw new CHttpException(404);
	    }
    }
    
	public function actionIndex()
	{	
		if ( isset($_GET['token'])){
			Yii::app()->functions->cancelPaypalOrder($_GET['token']);
		}
		
		if (Yii::app()->functions->isAlreadyInstall()){											
			if (isset($_GET['lang_id'])){
				Yii::app()->request->cookies['rst_lang_id'] = new CHttpCookie('rst_lang_id', $_GET['lang_id']);				
				if (!empty($_SERVER['HTTP_REFERER'])){
					header('Location: '.$_SERVER['HTTP_REFERER']);
				} else header('Location: '.Yii::app()->request->baseUrl);
			}				
			$this->render('home');
		} else {
			header('Location: '.Yii::app()->request->baseUrl."/install/");
		}
	}
	
	public function actionFooditem()
	{		        
		$this->render('food_item');
	}
	
	public function actionFoodOrder()
	{		 
		$this->render('food_order');
	}
	
	public function actionCart()
	{
		$this->render('cart');
	}
	
	public function actionCarryout()
	{
		$this->render('carryout');
	}
	
	public function actionDelivery()
	{
		$this->render('delivery');
	}
	
	public function actionReceipt()
	{
		$this->render('receipt');
	}
	
	public function actionSignup()
	{
		$this->render('signup');
	}
	
	public function actionPaypal()
	{
		$this->render('paypal_init');
	}
	
	public function actionPaypalVerify()
	{
		unset($_SESSION[KARENDERIA]['item']);    		
		unset($_SESSION['temp_voucher_code']);
	    unset($_SESSION['temp_voucher_amount']);
		$this->render('paypal_verify');
	}
	
	public function actionPaypalReceipt()
	{
		//$this->render('paypal_receipt');
		$this->render('receipt');
	}
	
	public function actionAjax()
	{		
		if (isset($_POST)){
		    $data=$_POST;			
		} else $data=$_GET;
		
		if (isset($_GET['tbl'])){
			$data=$_GET;
		}
		
		if (!isset($data['action'])){
			$data['action']='';
		}		
					
		$class=new AjaxSites;
	    $class->data=$data;
	    if (method_exists($class,$data['action'])){
	    	$class->$data['action']();	    
	    } else {
	    	$class->notExistMethod();
	    }	    
	    echo $class->output();
	    yii::app()->end();
	}
	
	public function actionLogout()
	{		
		yii::app()->functions->sessionInit();
		//unset($_SESSION[KARENDERIA]);
		unset($_SESSION[KARENDERIA]['login']);
    	unset($_SESSION[KARENDERIA]['user_info']);    	    	    	
    	header('Location: '.Yii::app()->request->baseUrl."/store/");
	}

	/*public function actionfblogin()
	{
		$this->render('fblogin');
	}*/
	
	public function actionCashonDeliver()
	{		
		$ajax_sites=new AjaxSites; 
		$trans_type='delivery';
		
		if (isset($_GET['trans_type'])){
			if (!empty($_GET['trans_type'])){
			   $trans_type=$_GET['trans_type'];
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
			$order_id=$ajax_sites->saveOrder(yii::app()->functions->userId(),$trans_type);                
			
			/*pre order*/
			$enabled_preorder=Yii::app()->functions->getOption("enabled_preorder");			
			if ( $enabled_preorder==1){
				header('Location: '.Yii::app()->request->baseUrl."/store/preOrder/order_id/".$order_id);
			} else header('Location: '.Yii::app()->request->baseUrl."/store/receipt/order_id/".$order_id);            
		} else {
			$msg=Yii::t("default","Sorry the minimum order amount is ").baseCurr().prettyPrice($minimum_order);
			header('Location: '.Yii::app()->request->baseUrl."/store/?msg=".urlencode($msg));
		}
	}
		
	public function actionPaypalInit()
	{		
		$ajax_sites=new AjaxSites; 
		$trans_type='delivery';
		if (isset($_GET['trans_type'])){
			if (!empty($_GET['trans_type'])){
			   $trans_type=$_GET['trans_type'];
			}
		}
        $order_id=$ajax_sites->saveOrder(yii::app()->functions->userId(),$trans_type,'paypal');        
        header('Location: '.Yii::app()->request->baseUrl."/store/paypal/?order_id=".$order_id); 
	}
	
	public function actionProfile()
	{
		$this->render('profile');
	}
	
	public function actionContactus()
	{
		$this->render('contact-us');
	}
	
	public function actionRecentorder()
	{
		$this->render('recent-order');
	}
	
	public function actionWishlist()
	{
		$this->render('wishlist');
	}
	
	public function actionViewReceipt()
	{
		$this->render('view-receipt');
	}
	
	public function actionEvents()
	{
		$this->render('events');
	}

	public function actionViewEvents()
	{
		$this->render('view-events');
	}
	
	public function actionReceiptPDF()
	{						
		require_once 'html2pdf_v4.03/html2pdf.class.php';
		$content =remove_html_comments($_SESSION['receipt_pdf']);		
        $html2pdf = new HTML2PDF('P','A5','en');
        $html2pdf->WriteHTML($content);
        $html2pdf->Output('receipt.pdf');
	}
	
	public function actionReservation()
	{
		$this->render('reservation');
	}
	
	public function actionPage()
	{
		$this->render('page');
	}
	
	public function actionOfflinePayment()
	{
		$this->render('offline-payment');
	}
	
	public function actionPreOrder()
	{
	    $this->render('pre-order');
	}
	
	public function actionBraintree()
	{
		$this->render('braintree');
	}
	
	public function actionStripeInit()
	{
		$this->render('stripe-init');
	}
	
	public function actionForgotPassword()
	{
		$this->render('forgot-password');
	}
	
	public function actionResetPassword()
	{
		$this->render('resetpassword');
	}
	
} /*END CONTROLLER*/