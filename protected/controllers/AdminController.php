<?php
/**
 * AdminController Controller
 *
 */
if (!isset($_SESSION)) { session_start(); }

class AdminController extends CController
{
	public $layout='admin_tpl';
	
	public function accessRules()
	{
		
	}
	
	public function filters()
	{		
		$store_name=Yii::app()->functions->getOption("store_name");		
		if (!empty($store_name)){			
			$this->setPageTitle($store_name . Yii::t("default"," Back Office"));
		} else {
		    $this->setPageTitle( Yii::t('default','Karenderia Back Office'));
		}
		$is_login=FALSE;						
		if (!empty($_COOKIE['rst_user'])){
			$user=json_decode($_COOKIE['rst_user']);			
			if (is_numeric($user[0]->user_id)){
				$is_login=TRUE;
			}
		}
		if (!$is_login){			
			if (!isset($_POST['action'])){
				$_POST['action']='';
			}
			if (!isset($_GET['logout']) && $_POST['action']!='login'){
			    $this->redirect(Yii::app()->request->baseUrl."/admin/?logout=true");			    
			}
		} 
	}	
	
	public function actionLogin()
	{
		
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
		if (isset($_GET['logout']) && $_GET['logout']=="true"){
		    unset($_COOKIE['rst_user']);
		}
		
		if (Yii::app()->functions->isAdminLogin()):
		    //$this->render('home',array('model'=>$model));
		    $this->render('home');
		else :		    
		    $this->layout='login_tpl';
			$model=new LoginForm;		
			if(isset($_POST['login_form']))
		    {	        		    	
		        $model->attributes=$_POST['login_form'];
		        if($model->validate() && $model->login())
		            $this->redirect(Yii::app()->request->baseUrl."/admin/home");
		    }
		    $this->render('login',array('model'=>$model));
	    endif;
	}
	
	public function actionHome()
	{		
		$this->render('home');
	}
	
	public function actionCategory()
	{		
		$this->render('category_list');
	}
	
	public function actionCategorynew()
	{		
		$this->render('category_new');
	}
	
	public function actionAjax()
	{
	
		/*if (isset($_GET)){			
		    $data=$_REQUEST;
		} else $data=$_POST;*/
		if (isset($_REQUEST['tbl'])){
		   $data=$_REQUEST;	
		} else $data=$_POST;
				
		if (isset($data['debug'])){
			dump($data);
		}
		$class=new AjaxAdmin;
	    $class->data=$data;
	    $class->$data['action']();	    
	    echo $class->output();
	    yii::app()->end();
	}
	
	public function actionItem()
	{
		$this->render('item_list');
	}
	
	public function actionItemNew()
	{
		$this->render('item_new');
	}
	
	public function actionSubCategoryNew()
	{
		$this->render('subcategory_new');
	}
	
	public function actionSubcategory()
	{
		$this->render('subcategory_list');
	}
	
	public function actionSubCategoryItem()
	{
		$this->render('subcategory_item_list');
	}
	
	public function actionSubCategoryItemNew()
	{
		$this->render('subcategory_item_new');
	}
	
	public function actionOtherItemSize()
	{
		$this->render('other-item-size');
	}
	
	public function actionCookingRef()
	{
		$this->render('cooking-ref');
	}
	
	public function actionSettings()
	{
		$this->render('settings');
	}
	
	public function actionPaypal()
	{
		$this->render('paypal');
	}
	
	public function actionUserManagement()
	{
		$this->render('user-management');
	}
	
	public function actionSortCategory()
	{
		$this->render('sortcategory');
	}
	
	public function actionSortItem(){
		$this->render('sort-item');
	}
	
	public function actionSortSubCategory()
	{
		$this->render('sort-subcategory');
	}
	
	public function actionSortSubCategoryitem()
	{
		$this->render('sort-subcategoryitem');
	}
	
	public function actionSortOtherItemSize()
	{
		$this->render('sort-otheritemsize');
	}
	
	public function actionSortCookingRef()
	{
		$this->render('sort-sortcookingref');
	}
	
	public function actionFeaturedItem()
	{
		$this->render('featured-item');
	}	
	
	public function actionRptRegUser()
	{
		$this->render('rpt-reg-user');
	}
	
	public function actionRptSalesReport()
	{
		$this->render('rpt-sales-report');
	}
	
	public function actionRptSales()
	{
		$this->render('rpt-sales');
    }
    
    public function actionRptSalesSummary()
    {
    	$this->render('rpt-sales-summary');
    }
    
    public function actionSocialSettings()
    {
    	$this->render('social-settings');
    }
    
    public function actionContactSettings()
    {
    	$this->render('contact-settings');
    }
        
    public function actionReceiptSettings()
    {
    	$this->render('receipt-settings');
    }
    
    public function actionViewOrder()
    {
    	$this->render('view-order');
    }
    
    public function actionTranslationSettings()
    {
    	$this->render('translation-settings');
    }
    
    public function actionTranslationAdd()
    {
    	$this->render('translation-add');
    }
    
    public function actionAssignLanguage()
    {
    	$this->render('assign-language');
    }
    
    public function actionCurrencySettings()
    {
    	$this->render('currency-settings');
    }
    
    public function actionOrderStatsSettings()
    {
    	$this->render('order-stats-settings');
    }    
    
    public function actionOrderSetStats()
    {
    	$this->render('order-set-stats');
    }   
    
    public function actionSmsSettings()
    {
    	$this->render('sms-settings');
    }
    
    public function actionSmsLogs()
    {
    	$this->render('smslogs');
    }
    
    public function actionSMSTPSettings()
    {
    	$this->render('smstpsettings');
    }
    
    public function actionManageLayout()
    {
    	$this->render('managelayout');
    }
    
    public function actionLayoutMenu()
    {
    	$this->render('layoutmenu');
    }
    
    public function actionLayoutThemes()
    {
    	$this->render('layoutthemes');
    }
    
    public function actionAlertSettings()
    {
    	$this->render('alertsettings');
    }
    
    public function actionEvents()
    {
    	$this->render('events');
    }
    
    public function actionEventsList()
    {
    	$this->render('event-list');
    }
    
    public function actionReservation()
    {
    	$this->render('reservation');
    }
    
    public function actionAddPage()
    {
    	$this->render('addpage');
    }
    
    public function actionPageList()
    {
    	$this->render('pagelist');
    }
    
    public function actionPageMenu()
    {
    	$this->render('page-menu');
    }
    
    public function actionSeometas()
    {
    	$this->render('seometas');
    }
    
    public function actionSeositeMap()
    {
    	$this->render('seositemap');
    }
    
    public function actionVoucher()
    {
    	$this->render('voucher');
    }
    
    public function actionVoucherDetails()
    {
    	$this->render('voucherdetails');
    }
    
    public function actionUserAdd()
    {
    	$this->render('user-add');
    }
    
    public function actionMultiOptions()
	{
		$this->render('multioptions');
	}
	
	public function actionSortMultiOptions()
	{
		$this->render('sortmultioptions');
	}
	
	public function actionBrainTree()
	{
		$this->render('braintree');
	}
	
	public function actionStripe()
	{
		$this->render('stripe');
	}
	
	public function actionForgotPassword()
	{
		$this->render('forgot-password');
	}
}
/*END CONTROLLER*/
