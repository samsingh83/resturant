<?php
/*******************************************
@author : bastikikang 
@author emai: basti@codemywebapps.com
@author website : http://codemywebapps.com
*******************************************/

class Functions extends CApplicationComponent
{
	public $data;
	public $sms_msg;
	
	public function isAdminLogin()
	{		
		$is_login=FALSE;		
		if (!empty($_COOKIE['rst_user'])){
			$user=json_decode($_COOKIE['rst_user']);						
			if (is_numeric($user[0]->user_id)){
				$is_login=TRUE;
			}
		}
		if ($is_login){
			return true;
		}
		return false;
	}
	
	public function getAdminId()
	{					
		if (!empty($_COOKIE['rst_user'])){	
			$user=json_decode($_COOKIE['rst_user']);											
			if (is_numeric($user[0]->user_id)){				
				return $user[0]->user_id;
			}
		}		
		return false;
	}	
	
	public function getAdminLanguage()
	{					
		if (!empty($_COOKIE['rst_user'])){	
			$user=json_decode($_COOKIE['rst_user']);											
			if (isset($user[0]->lang_id)){
				if (is_numeric($user[0]->lang_id)){				
					return $user[0]->lang_id;
				}
			}
		}		
		return false;
	}	
	
	public function getAdminAccess()
	{					
		if (!empty($_COOKIE['rst_user'])){	
			$user=json_decode($_COOKIE['rst_user']);														
			$user_access=!empty($user[0]->user_access)?json_decode($user[0]->user_access):false;
			return $user_access;
		}		
		return false;
	}	
	
	public function getAdmiUserType()
	{					
		if (!empty($_COOKIE['rst_user'])){	
			$user=json_decode($_COOKIE['rst_user']);																	
			$user_type=$user[0]->user_type;
			return $user_type;
		}		
		return false;
	}	
	
	public function getCategory()
	{
		$data_feed='';
		$stmt="
		SELECT * FROM
		{{category}}
		WHERE
		status IN ('publish')
		ORDER BY sequence ASC
		";
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){			
			if ($this->data=="list"){
				foreach ($rows as $val) {									   
				   $data_feed[$val['cat_id']]=$val['category_name'];
				}
				return $data_feed;
			} else return $rows;
		}
		return FALSE;
	}
	
	public function getCategoryById($cat_id='')
	{
		$data_feed='';
		$stmt="
		SELECT * FROM
		{{category}}
		WHERE
		cat_id ='".addslashes($cat_id)."'
		LIMIT 0,1
		";
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){			
			return $rows;
		}
		return FALSE;
	}
	
	public function getSize()
	{				
		$data_feed='';
		$stmt="
		SELECT * FROM
		{{size}}			
		WHERE
		status IN ('published','publish')
		ORDER BY sequence ASC
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 				
		if (is_array($rows) && count($rows)>=1){
			if ($this->data=="list"){				
				$data_feed[]="";
				foreach ($rows as $val) {									   
				   $data_feed[$val['size_id']]=$val['size_name'];
				}
				return $data_feed;
			} else return $rows;
		}
		return FALSE;
	}

	public function prettyPrice($price='')
	{
		$size=$this->getSize();
		$price_list='';
		if (!empty($price)){
			$price=json_decode($price);
			if (is_array($price) && count($price)>=1){
				foreach ($price as $val) {										
					if (array_key_exists($val->size, (array)$size )){
						$item_size=$size[$val->size];
					} else $item_size='';
					$price_list.="<li><span>".$this->getCurrencyCode().$val->price."</span>".$item_size."</li>";
				}
			}			
		}
		return $price_list;
	}
	
	public function checkbox($val='',$data=array())
	{
		if (in_array($val,(array)$data)){
			echo "checked";
		}		
	}
	
	public function getCurrencyCode()
	{		
		$db_ext=new DbExt;		
		$stmt="SELECT * FROM
		{{currency}}		       
		WHERE
		currency_code='".yii::app()->functions->getOption('currency_code')."'
		LIMIT 0,1
		";
		if ($res=$db_ext->rst($stmt)){			
			return $res[0]['currency_symbol'];
		}
		return "$";
	}
	
	public function getCurrencyCodes()
	{		
		$db_ext=new DbExt;		
		$stmt="SELECT * FROM
		{{currency}}		       
		WHERE
		currency_code='".yii::app()->functions->getOption('currency_code')."'
		LIMIT 0,1
		";
		if ($res=$db_ext->rst($stmt)){
			return $res[0]['currency_code'];
		}
		return "USD";
	}
	
	public function currencyList()
    {
        $data_feed='';
		$stmt="
		SELECT * FROM
		{{currency}}					
		ORDER BY currency_code ASC
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll();
		if (is_array($rows) && count($rows)>=1){			
			$data_feed[]="";
			foreach ($rows as $val) {									   
			   $data_feed[$val['currency_code']]=$val['currency_code'];
			}
			return $data_feed;			
		}
		return FALSE;
    }
    
    public function currencyListRaw()
    {
    	return array(
    	  'USD'=>"USD",
    	  'EUR'=>"EUR",
    	  "JPY"=>"JPY",
    	  "AUD"=>"AUD",
    	  "MXN"=>"MXN",
    	  "NZD"=>"NZD",
    	  "HKD"=>"HKD",
    	  "CNY"=>"CNY",
    	  "MYR"=>"MYR",
    	  "CAD"=>"CAD"
    	);    	
    }
	
    public function getSubcategory()
	{
		$data_feed='';
		$stmt="
		SELECT * FROM
		{{subcategory}}
		ORDER BY sequence ASC
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 				
		if (is_array($rows) && count($rows)>=1){
			if ($this->data=="list"){
				foreach ($rows as $val) {									   
				   $data_feed[$val['subcat_id']]=$val['subcategory_name'];
				}
				return $data_feed;
			} else return $rows;
		}
		return FALSE;
	}
	
    public function getSubcategoryById($id='')
	{
		$data_feed='';
		$stmt="
		SELECT * FROM
		{{subcategory}}
		WHERE
		subcat_id ='".addslashes($id)."'
		";
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
		    return $rows;
		}
		return FALSE;
	}	
	
	public function getSubcategoryItem()
	{
		$data_feed='';
		$stmt="
		SELECT * FROM
		{{subcategory_item}}
		ORDER BY sequence ASC
		";
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			if ($this->data=="list"){
				foreach ($rows as $val) {							   
				   $data_feed[$val['sub_item_id']]=$val['sub_item_name'];
				}
				return $data_feed;
			} else return $rows;
		}
		return FALSE;
	}
	
	public function getSubcategoryItemFullDetails()
	{
		$data_feed='';
		$stmt="
		SELECT * FROM
		{{subcategory_item}}
		ORDER BY sub_item_id ASC
		";
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 				
		if (is_array($rows) && count($rows)>=1){			
			foreach ($rows as $val) {				   
			   $data_feed[$val['sub_item_id']]=$val;
			}
			return $data_feed;
		}
		return FALSE;
	}	
	
	public function subcategoryList()
	{
		$list='';
		$stmt="SELECT a.*
		       FROM {{subcategory}} a
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			foreach ($rows as $val) {
				$stmt2="SELECT a.*,
				        (
				        select sub_item_name
				        from {{subcategory_item}}
				        where
				        sub_item_id=a.sub_item_id
				        ) as sub_item_name
				        FROM
				        {{subcat_relationship}} a
				        WHERE
				        subcat_id='".addslashes($val['subcat_id'])."'
				";
				$rows2=$connection->createCommand($stmt2)->queryAll(); 		
				$list[]=array(
				   'subcat_id'=>$val['subcat_id'],
				   'subcategory_name'=>$val['subcategory_name'],
				   'sub_item'=>$rows2
				);
			}
			return $list;
		}
		return FALSE;
	}
	
    public function getCookingref()
	{
		$data_feed='';
		$stmt="
		SELECT * FROM
		{{cooking_ref}}
		ORDER BY sequence ASC
		";
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			if ($this->data=="list"){
				foreach ($rows as $val) {									   
				   $data_feed[$val['cook_id']]=$val['cooking_name'];
				}
				return $data_feed;
			} else return $rows;
		}
		return FALSE;
	}	
		
	public function updateOption($option_name='',$option_value='')
	{
		$stmt="SELECT * FROM
		{{option}}
		WHERE
		option_name='".addslashes($option_name)."'
		";
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		
		$params=array(
		'option_name'=> addslashes($option_name),
		'option_value'=> addslashes($option_value)
		);
		$command = Yii::app()->db->createCommand();
		
		if (is_array($rows) && count($rows)>=1){
			$res = $command->update('{{option}}' , $params , 
				                     'option_name=:option_name' , array(':option_name'=> addslashes($option_name) ));
		    if ($res){
		    	return TRUE;
		    } 
		} else {			
			if ($command->insert('{{option}}',$params)){
				return TRUE;
			}
		}
		return FALSE;
	}
	
	public function getOption($option_name='')
	{
		$stmt="SELECT * FROM
		{{option}}
		WHERE
		option_name='".addslashes($option_name)."'
		LIMIT 0,1
		";
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return stripslashes($rows[0]['option_value']);
		}
		return '';
	}
	
	public function getDays()
	{
		return array(
		  'monday'=>Yii::t("default",'monday'),
		  'tuesday'=>Yii::t("default",'tuesday'),
		  'wednesday'=>Yii::t("default",'wednesday'),
		  'thursday'=>Yii::t("default",'thursday'),
		  'friday'=>Yii::t("default",'friday'),
		  'saturday'=>Yii::t("default",'saturday'),
		  'sunday'=>Yii::t("default",'sunday')
		);
	}
	
	public function userStatus()
	{
		return array(
		  'active'=>Yii::t("default",'active'),
		  'suspended'=>Yii::t("default",'suspended')
		);
	}
	
	public function getFoodItem($cat_id='')
	{
		$data_feed='';
		$stmt="
		SELECT a.*,b.* 
		FROM
		{{item_relationship}} a
		
		LEFT JOIN {{item}} b
        ON
        a.item_id  = b.item_id
		
		WHERE
		cat_id='".addslashes($cat_id)."'
		
		AND
		a.item_id IN ( select item_id from {{item}} where item_id=a.item_id  )
		
		AND
		b.status IN ('publish')
		
		ORDER BY sequence ASC
		";				
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}
	
	public function getFoodItemList()
	{
		$stmt="
		SELECT * FROM
		{{item}}
		ORDER BY sequence ASC		
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			if ($this->data=="list"){
				foreach ($rows as $val) {									   
				   $data_feed[$val['item_id']]=$val['item_name'];
				}
                return $data_feed;
			} else return $rows;			
		}
		return FALSE;
	}	
		
	public function getFoodItemListActive()
	{
		$stmt="
		SELECT * FROM
		{{item}}
		WHERE
		status IN ('publish','published')
		ORDER BY sequence ASC		
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			if ($this->data=="list"){
				foreach ($rows as $val) {									   
				   $data_feed[$val['item_id']]=$val['item_name'];
				}
                return $data_feed;
			} else return $rows;			
		}
		return FALSE;
	}		
	
	public function getFeatured($featured=0)
	{
		$stmt="
		SELECT * FROM
		{{item}}
		WHERE
		is_featured='".addslashes($featured)."'
		ORDER BY sequence ASC		
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}	
	
	public function getFoodItemDetails($item_id='')
	{
		$stmt="
		SELECT * FROM
		{{item}}
		WHERE
		item_id='".addslashes($item_id)."'
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}	
	
	public function dump($data='')
	{
		echo "<pre>";print_r($data);echo "</pre>";
	}
	
	public function getOrder($order_id='')
	{
		$stmt="
		SELECT * FROM
		{{order_details}}
		WHERE
		order_id ='".addslashes($order_id)."'
		ORDER BY id ASC
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}
	
	public function getOrderByUser($order_id='')
	{
		$stmt="
		SELECT * FROM
		{{order_details}}
		WHERE
		order_id ='".addslashes($order_id)."'
		AND
		client_id='".$this->userId()."'
		ORDER BY id ASC
		";				
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}	
	
	public function getOrderInfo($order_id='')
	{
		$stmt="
		SELECT a.*,
		(
		select transaction_id 	
		from
		{{braintree_trans}}
		where
		order_id=a.order_id
		)  as braintree_id
		 FROM
		{{order}} a
		WHERE
		order_id ='".addslashes($order_id)."'
		LIMIT 0,1		
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}	
	
	public function getClientInfo($client_id='')
	{
		$stmt="
		SELECT * FROM
		{{client}}
		WHERE
		client_id ='".addslashes($client_id)."'
		LIMIT 0,1		
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}
	
	public function login($username='',$password='',$md5=true)
	{
		if ($md5==TRUE){
			$password=md5($password);
		} 
		$stmt="
		SELECT * FROM
		{{client}}
		WHERE
		email =".Yii::app()->db->quoteValue($username)."
		AND
		password=".Yii::app()->db->quoteValue($password)."
		AND
		status='active'
		LIMIT 0,1		
		";				
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}	
	
	public function sessionInit()
	{
		if (!isset($_SESSION)) {session_start();}
	}
	
	public function userId()
	{
		if (isset($_SESSION[KARENDERIA]['user_info'])){
			if (is_array($_SESSION[KARENDERIA]['user_info']) && count($_SESSION[KARENDERIA]['user_info'])>=1){
			   return $_SESSION[KARENDERIA]['user_info']['client_id'];	
			} else return FALSE;
		} else return FALSE;
	}
	
	public function isUserLoggedIn()
	{
		if ($this->userId()){
			return TRUE;
		}
		return FALSE;
	}
	
	function updateSalesOrder($params='',$order_id='')
	{
		if (is_numeric($order_id)){
			$command = Yii::app()->db->createCommand();
			try {
		       $up = $command->update('{{order}}' , $params , 
			   'order_id=:order_id' , array(':order_id'=> addslashes($order_id) ));
			   return TRUE;
		    } catch (Exception $e){
		        $this->msg='Caught exception: '. $e->getMessage(). "\n";
		    }    		    
		}
	    return FALSE;
	}
	
	public function accountExist($email='')
    {
		$stmt="
		SELECT * FROM
		{{client}}
		WHERE
		email='".addslashes($email)."'
		LIMIT 0,1
		";	
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll();	
		if (is_array($rows) && count($rows)>=1){	
			return $rows;
		} else return FALSE;	
    }
    
	public function accountExistSocial($email='',$social='fb')
    {
		$stmt="
		SELECT * FROM
		{{client}}
		WHERE
		email='".addslashes($email)."'
		AND
		social_strategy ='".addslashes($social)."'
		LIMIT 0,1
		";	
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll();	
		if (is_array($rows) && count($rows)>=1){	
			return $rows;
		} else return FALSE;	
    }
        
	public function socialShare($url='',$settings='',$text="")
	{		
		if (!isset($settings['wa_social'])){
			$settings['wa_social']='';
		}
		if (!isset($settings['wa_social_fb'])){
			$settings['wa_social_fb']='';
		}
		if (!isset($settings['wa_social_twiter'])){
			$settings['wa_social_twiter']='';
		}
		if (!isset($settings['wa_social_google'])){
			$settings['wa_social_google']='';
		}
		if (!isset($settings['wa_social_link'])){
			$settings['wa_social_link']='';
		}
		if (!isset($settings['wa_social_pin'])){
			$settings['wa_social_pin']='';
		}
		$div1='';
		$div2='';		
		$fb='';$twiter='';$linkin='';$pin_interest='';$google_share='';
		if ( $settings['wa_social']==1):									
		$fb='<a href="javascript:;" rel="https://www.facebook.com/sharer/sharer.php?u='.urlencode($url).'&display=popup" class="social_fb_share">'.$text.'</a>';		
		$twiter='<a href="javascript:;" rel="http://twitter.com/share?url='.urlencode($url).'" class="social_twiter">'.$text.'</a>';
		$linkin='<a href="javascript:;" rel="https://www.linkedin.com/cws/share?url='.urlencode($url).'" class="social_linkin">'.$text.'</a>';
		$pin_interest='<a href="javascript:;" rel="http://pinterest.com/pin/create/button/?url'.urlencode($url).'" class="social_pin">'.$text.'</a>';
		
		$google_share='<a href="javascript:;" rel="https://plus.google.com/share?url='.urlencode($url).'" class="social_google">'.$text.'</a>';
					
		$div1='';
		$div2='';			
		endif;
		
		if ( $settings['wa_social_fb']<>1){
			$fb='';
		}
		if ( $settings['wa_social_twiter']<>1){
			$twiter='';
		}
		if ( $settings['wa_social_google']<>1){
			$google_share='';
		}
		if ( $settings['wa_social_link']<>1){
			$linkin='';
		}
		if ( $settings['wa_social_pin']<>1){
			$pin_interest='';
		}					
		return $div1.$fb.$twiter.$google_share.$linkin.$pin_interest.$div2;
    }				    
    
    public function currentPageUrl()
    {
    	$page_url= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];      
    	return $page_url;
    }
    
    public function recentOrderWidget()
    {
    	if (!$this->isUserLoggedIn()){
    		return ;
    	}
    	yii::app()->functions->sessionInit();
    	$stmt="
		SELECT a.*,
		(
		select description from
		{{order_status}}
		where
		stats_id=a.stats_id
		) as stats_desc		
		 FROM
		{{order}} a
		WHERE
		client_id ='".addslashes($this->userId())."'				
		ORDER BY order_id DESC
		LIMIT 0,5
		";			
    	/*AND
		status='paid'	*/
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll();		
    	?>
    	<div class="recent_order_wrap">
    	<h3><span class="glyphicon glyphicon-th-list"></span> <?php echo Yii::t('default',"Your Recent Order")?></h3>
    	<div class="inner">
    	<?php if (is_array($rows) && count($rows)>=1):?>
    	<ul>
    	<?php foreach ($rows as $val):?>
    	  <li><span class="glyphicon glyphicon-cutlery"></span>
    	  <a href="javascript:;" rel="<?php echo $val['order_id']?>" class="recent_order_to_cart"><?php echo date("F d",strtotime($val['date_created']))?></a>
    	  <a data-id="<?php echo $val['order_id']?>" href="javascript:;" class="view_receipt"><span class="glyphicon glyphicon-file"></span><?php echo Yii::t("default","View Receipt")?></a>
    	  <?php $order=!empty($val['json_order_details'])?json_decode($val['json_order_details']):false;?>    	      	  
    	  
    	  <div class="order_stats"><i class="fa fa-file-text"></i>  <?php echo $val['stats_desc']?></div>
    	  
    	   <ul>
    	    <?php if (is_array($order->item) && count($order->item)>=1):?>    	    
    	    <?php foreach ($order->item as $val_item):?>
    	    <?php 
    	    $food_item=yii::app()->functions->getFoodItemDetails($val_item->item_id);     	    
    	    ?>
    	    <li>
    	    <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$food_item[0]['photo']?>" alt="" title="">
    	    <?php echo $food_item[0]['item_name']?>
    	    </li>
    	    <?php endforeach;?>
    	    <?php endif;?>
    	   </ul>
    	  </li>    
    	<?php endforeach;;?>	
    	</ul>
    	<?php else :?>
    	 <p class="alert alert-warning"><?php echo Yii::t('default',"No history")?></p>
    	<?php endif;?>
    	</div>
    	</div>
    	<?php
    }
    
    public function categoryMenu()
    {
    	?>
    	<div class="category_menu">
    	 <h3><span class="glyphicon glyphicon-th-list"></span> <?php echo Yii::t('default',"Categories")?></h3>
    	 <div  class="inner">
    	  <ul>
    	  <?php $this->data="none_list";?>
    	  <?php if ($res=$this->getCategory()):?>
    	  <?php foreach ($res as $val): //dump($val);?>    	  
    	   <li>
    	   <span class="glyphicon glyphicon-plus"></span>
    	   <!--<a href="<?php echo Yii::app()->request->baseUrl."/store/food-item/?cat-id=".$val['cat_id']?>"><?php echo $val['category_name']?></a>-->
    	   <a href="javascript:;" class="sidebar_parent_list"><?php echo $val['category_name']?></a>
    	   <?php if ($res2=$this->getFoodItem($val['cat_id'])): //dump($res2);?>
    	   <ul class="sibar_child_list">
    	     <?php foreach ($res2 as $val_item): //dump($val_item);?>
    	     <li><a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/?item-id=".$val_item['item_id']?>"><?php echo $val_item['item_name']?></a></li>
    	     <?php endforeach;?>
    	   </ul>
    	   <?php endif;?>
    	   </li>
    	   <?php endforeach;?>
    	   <?php endif;?>
    	  </ul>
    	 </div>
    	</div>
    	<?php
    }
    
    public function getSameItem($cat_id)
    {    	
    	if (isset($_GET['item-id'])){
    		$and="AND a.item_id NOT IN ('".addslashes($_GET['item-id'])."')";
    	}
    	$stmt="
		SELECT a.*,b.* 
		FROM
		{{item_relationship}} a
		
		LEFT JOIN {{item}} b
        ON
        a.item_id  = b.item_id
		
		WHERE
		cat_id='".addslashes($cat_id)."'
		
		$and
		
		AND
		a.item_id IN ( select item_id from {{item}} where item_id=a.item_id  )
		
		AND
		b.status IN ('publish')
						
		ORDER BY cat_id DESC
		";		    	
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll();		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return False;
    }
    
    public function getSameCategory($cat_id='')
    {
    	$stmt="
		SELECT * FROM
		{{category}}
		WHERE
		cat_id NOT IN ('".addslashes($cat_id)."')
		AND
		status IN ('publish')
		ORDER BY cat_id DESC
		";    	
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 				
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return false;
    }
    
    public function getItemRelationship($item_id='')
    {
        $stmt="
		SELECT * FROM
		{{item_relationship}}
		WHERE
		item_id='".addslashes($item_id)."'
		LIMIT 0,1
		";    	
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 				
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return false;
    }
	
    public function breadcrumbs()
    {    	
    	$controllerId = Yii::app()->controller->id;    	
    	$page=Yii::app()->controller->getAction()->getId();    	
    	
    	$item['item_name']='';
    	$cat_item['cat_id']='';
    	if (isset($_GET['item-id'])){
    		if ($item=$this->getFoodItemDetails($_GET['item-id'])){
    		    $item['item_name']=$item[0]['item_name'];
    		}    		
    		if ($item_cat=$this->getItemRelationship($_GET['item-id'])){     			
    			$cat_item['cat_id']=$item_cat[0]['cat_id'];
    		}
    	}    
    	
    	if (isset($_GET['cat-id'])){
    		if ($cat=$this->getCategoryById($_GET['cat-id'])){    			
    			$cat_item['category_name']=$cat[0]['category_name'];
    		}
    	}
    	
    	if (isset($cat_item['cat_id'])){
    		if ($cat=$this->getCategoryById($cat_item['cat_id'])){
    			$cat_item['category_name']=$cat[0]['category_name'];
    		}
    	}
    	//echo $email = Yii::app()->request->getQuery('cat-id');
    	//CHttpRequest::getQuery('email');  
    	//dump($page);
    	  	
    	switch ($page) {
    		case "FoodItem":    			    			
    			$links[]=$cat_item['category_name'];
    			break;
    	
    		case "FoodOrder":    		    		    
    			$links[$cat_item['category_name']]=array('store/food-item/','cat-id'=>$cat_item['cat_id']);
    			$links[]=strip_tags($item['item_name']);
    			break;
    			
    		case "delivery":		
    		    $links[]=Yii::t("default",'Delivery');
    		    break;
    		    
    		case "carryout":    
    		    $links[]=Yii::t("default",'Carry Out');
    		    break;
    		    
    		case "receipt":    
    		    $links[]=Yii::t("default",'Receipt');
    		    break;
    		    
    		case "cart":    
    		    $links[]=Yii::t("default",'Cart');
    		    break;    
    		    
    		case "PaypalReceipt":    
    		    $links[]=Yii::t("default",'Receipt');
    		    break;    
    		    
    		case "PaypalVerify":    
    		    $links[]=Yii::t("default",'Verify Payment');
    		    break;
    		    
    		case "signup":    
    		    $links[]=Yii::t("default",'Sign up');
    		    break;
    		    
    		case "ContactUs":    
    		    $links[]=Yii::t("default",'Contact Us');
    		    break;
    		    
    		case "wishlist":    
    		    $links[]=Yii::t("default",'WishList');
    		    break;    
    		       
    		case "RecentOrder":     
    		    $links[]=Yii::t("default",'Recent Order');
    		    break;    
    		    
    	    case "events":     
    		    $links[]=Yii::t("default",'Events');
    		    break;    
    		    
    	    case "ViewEvents":    
    	        $links[]=Yii::t("default",'View Events');
    		    break;    
    		    
    		default:
    			$links[]=Yii::t("default",'Menu');
    			break;
    	}    	
    	return $links;
    }
    
    public function paypalSavedToken($params='')
    {    	    	
		$command = Yii::app()->db->createCommand();
		if ($command->insert('{{paypal_checkout}}',$params)){
		   return TRUE;
		} 
		return FALSE;
    }
    
    public function getPaypalConnection()
    {
    	 $paypal_mode=yii::app()->functions->getOption('paypal_mode');    	 
		 $paypal_con=array();		 
		 if ($paypal_mode=="sandbox"){
		  	  $paypal_con['mode']="sandbox";
		  	  $paypal_con['sandbox']['paypal_nvp']='https://api-3t.sandbox.paypal.com/nvp';
		  	  $paypal_con['sandbox']['paypal_web']='https://www.sandbox.paypal.com/cgi-bin/webscr';
		  	  $paypal_con['sandbox']['user']=yii::app()->functions->getOption('sanbox_paypa_user');
		  	  $paypal_con['sandbox']['psw']=yii::app()->functions->getOption('sanbox_paypa_pass');
		  	  $paypal_con['sandbox']['signature']=yii::app()->functions->getOption('sanbox_paypa_signature');
		  	  $paypal_con['sandbox']['version']='61.0';
		  	  $paypal_con['sandbox']['action']='Sale';
		  } else {
		  	  $paypal_con['mode']="live";
		  	  $paypal_con['live']['paypal_nvp']='https://api-3t.paypal.com/nvp';
		  	  $paypal_con['live']['paypal_web']='https://www.paypal.com/cgi-bin/webscr';
		  	  $paypal_con['live']['user']=yii::app()->functions->getOption('live_paypa_user');
		  	  $paypal_con['live']['psw']=yii::app()->functions->getOption('live_paypa_pass');
		  	  $paypal_con['live']['signature']=yii::app()->functions->getOption('live_paypa_signature');
		  	  $paypal_con['live']['version']='61.0';
		  	  $paypal_con['live']['action']='Sale';
		  }
		  return $paypal_con;
    }
    
    public function getOrderByPaypalToken($token='')
    {
    	$stmt="
    	SELECT a.order_id,a.token,
    	b.json_order_details,b.trans_type
    	FROM {{paypal_checkout}} a
    	LEFT JOIN {{order}} b
    	ON a.order_id=b.order_id    	
    	WHERE
    	a.token='".addslashes($token)."'
		";    	
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 						
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return false;
    }
    
    public function getPaypalTransaction($token='')
    {
    	$db_ext=new DbExt;
    	$stmt="SELECT * FROM
    	      {{paypal_payment}}
    	      WHERE TOKEN='".addslashes($token)."'
    	      LIMIT 0,1
    	";    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return FALSE;
    }  
    
    public function getPaypalTransactionByOrderId($order_id='')
    {
    	$db_ext=new DbExt;
    	$stmt="SELECT * FROM
    	      {{paypal_payment}}
    	      WHERE order_id='".addslashes($order_id)."'
    	      LIMIT 0,1
    	";    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return FALSE;
    }  
    
    public function adminBreadCrumbs()
    {
    	
    	$crumbs['category']=Yii::t("default","Category");
    	$crumbs['categorynew']=Yii::t("default","Category New");
    	$crumbs['CategoryNew']=Yii::t("default","Category");
    	$crumbs['item']=Yii::t("default","Food Item");
    	$crumbs['itemnew']=Yii::t("default","Food Item");
    	$crumbs['subcategory']=Yii::t("default","AddOn Category");
    	$crumbs['subcategorynew']=Yii::t("default","AddOn Category");
    	$crumbs['subcategoryitem']=Yii::t("default","AddOn Item");
    	$crumbs['subcategoryitemnew']=Yii::t("default","AddOn Item");
    	$crumbs['otheritemsize']=Yii::t("default","Size");
    	$crumbs['cookingref']=Yii::t("default","Cooking Reference");
    	$crumbs['settings']=Yii::t("default","Settings");
    	$crumbs['paypal']=Yii::t("default","Paypal");
    	$crumbs['UserManagement']=Yii::t("default","User Management");
    	$crumbs['sortitem']=Yii::t("default","Sort Food Item");
    	$crumbs['featureditem']=Yii::t("default","Featured Item");
    	$crumbs['sortsubcategory']=Yii::t("default","Sort category");
    	$crumbs['sortsubcategoryitem']=Yii::t("default","Sort addon category");
    	$crumbs['sortotheritemsize']=Yii::t("default","Sort Size");
    	$crumbs['RptRegUser']=Yii::t("default","Registered User");    	
    	$crumbs['RptSalesReport']=Yii::t("default","Sales Report");
    	$crumbs['RptSales']=Yii::t("default","Sales Report By item");
    	$crumbs['RptSalesSummary']=Yii::t("default","Sales Summary Report");
    	$crumbs['ReceiptSettings']=Yii::t("default","Receipt Settings");
    	$crumbs['home']=Yii::t("default","Dashboard");
    	$crumbs['ViewOrder']=Yii::t("default","Order detail");
    	$crumbs['ContactSettings']=Yii::t("default","Contact Settings");
    	$crumbs['SocialSettings']=Yii::t("default","Social Settings");
    	
    	$crumbs['orderstatssettings']=Yii::t("default","Manage Order Status");
    	$crumbs['OrderStatsSettings']=Yii::t("default","Manage Order Status");
    	$crumbs['OrderSetStats']=Yii::t("default","Manage Order Status");
    	
    	//echo Yii::app()->controller->getAction()->getId();
    	$links='';    	        	
    	
    	$crumbs_text='';    	
    	if (array_key_exists(Yii::app()->controller->getAction()->getId(),$crumbs)){
    		$crumbs_text=$crumbs[Yii::app()->controller->getAction()->getId()];
    	}    
    	
    	$links=array(
       'homeLink'=>CHtml::link(Yii::t("default","Home"), Yii::app()->request->baseUrl."/admin"),
       'htmlOptions'=>array('class'=>'glyphicon glyphicon-home'),                   
          'links'=>array(          
          $crumbs_text
          ));
        
        return $links;
    }
    
    public function featuredFoodItem()
	{
		$stmt="
		SELECT * FROM
		{{item}}
		WHERE
		is_featured='1'
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows;
		}
		return FALSE;
	}	
	
	public function verifyPassword($password='',$client_id='')
	{
		if (empty($client_id)){
			$client_id=Yii::app()->functions->userId();
		}
		$db_ext=new DbExt;
		$stmt="SELECT * FROM
		       {{client}}
		       WHERE client_id='".addslashes($client_id)."'		       
		       LIMIT 0,1
		";
		if ($res=$db_ext->rst($stmt)){			
			if ($res[0]['password']==md5($password)){
				return true;
			}
			if ($res[0]['social_strategy']=="fb"){
				return true;
			}		
		}
		return false;
	}
	
    public function sendEmail($to='',$from='',$subject='',$body='')
    {    			    	
		$headers  = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
		
$message =<<<EOF
$body
EOF;
		$headers  = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
				
		if (!empty($to)) {
			if (@mail($to, $subject, $message, $headers)){
				return true;
			}
		}
    	return false;
    }    		      

    public function smarty($search='',$value='',$subject='')
    {	
	   return str_replace("{".$search."}",$value,$subject);
    }
    
    public function formatAsChart($data='')
    {
    	$chart_data='';
    	if (is_array($data) && count($data)>=1){
	    	foreach ($data as $key => $val) {
	    		$key=addslashes($key);
	    		$chart_data.="[\"$key\",$val],";
	    	}
	    	$chart_data=substr($chart_data,0,-1);
	    	return "[[$chart_data]]";
    	} 
    	return "[[0]]";
    }
    
    public function newOrderList($viewed='')
    {
    	
    	$and='';
    	if (is_numeric($viewed)){
    		$and.=" AND viewed='0'";
    	}
    	$db_ext=new DbExt;    	
    	$stmt="SELECT a.*,
    	
    	      (
    	      select fullname
    	      from
    	      {{client}}
    	      where
    	      client_id=a.client_id
    	      ) as client_name,
    	      
    	      (
    	      select description
    	      from {{order_status}}
    	      where stats_id = a.stats_id
    	      ) as status_desc
    	      
    	      FROM
    	      {{order}} a
    	      WHERE    	          	      
    	      date_created like '".date('Y-m-d')."%'
    	      $and
    	      ORDER BY date_created DESC
    	";
    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }   

    public function isAlreadyInstall()
    {
    	$db_ext=new DbExt;
    	$stmt="SHOW TABLE STATUS LIKE '{{user}}'";	
    	if ($res=$db_ext->rst($stmt)){
    		return true;
    	}
    	return false;    
    }        

    public function getSourceTranslation($lang_id='')
    {
    	$db_ext=new DbExt;
    	$stmt="SELECT * FROM
    	{{languages}}
    	WHERE
    	lang_id='".addslashes($lang_id)."'
    	LIMIT 0,1
    	";    	
    	if ($res=$db_ext->rst($stmt)){
    		$translated_text=!empty($res[0]['source_text'])?(array)json_decode($res[0]['source_text']):array();
    	    return $translated_text;
    	}
    	return false;
    }   
    
    public function languageInfo($lang_id='')
    {
    	$db_ext=new DbExt;
    	$stmt="SELECT * FROM {{languages}} 
    	  WHERE lang_id='".addslashes($lang_id)."' 
    	  LIMIT 0,1
    	  ";	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;    
    }
    
    public function inArray($val='',$source='')
    {
    	if (is_array($source) && count($source)>=1){
    		if (array_key_exists($val,$source)){
    			return $source[$val];
    		}    	
    	}
    	return '';    
    }
    
    public function availableLanguage($as_list=true)
    {
    	if ($as_list){
    		$lang_list['']=Yii::t("default","Default english");
    	}        	
    	$db_ext=new DbExt;
    	$stmt="SELECT lang_id,country_code,language_code
    	 FROM {{languages}} 
    	 WHERE
    	 status in ('publish','published')
    	 ";	
    	if ($res=$db_ext->rst($stmt)){    		
    		foreach ($res as $val) {    			
    			$lang_list[$val['lang_id']]=$val['country_code']." ".$val['language_code'];
    		}    		
    	}
    	return $lang_list;    
    }   
    
    public function getFlagByCode($country_code='')
    {    	
    	$country_code_ups=$country_code;
    	$country_code_list=require 'CountryCode.php';    	
    	$country_code=strtolower($country_code);    
    	$path_flag=Yii::getPathOfAlias('webroot')."/assets/images";
    	$base_url=Yii::app()->request->baseUrl."/assets/images";
    	if (!empty($country_code)){    		
    		$file=$country_code.".png";    		    		    		    		
    		if (array_key_exists($country_code_ups,(array)$country_code_list)){
    			$alt=$country_code_list[$country_code_ups];
    		} else $alt=$country_code_ups;
    		if (file_exists($path_flag."/flags/$file")){    			
    			return  "<img class=\"flags\" src=\"$base_url/flags/$file\" alt=\"$alt\" title=\"$alt\" />";
    		}
    	}
    	return false;    
    }
    
    public function getAssignLanguage()
    {
    	$lang='';
    	$db_ext=new DbExt;
    	$stmt="SELECT lang_id,country_code,language_code
    	 FROM {{languages}} 
    	 WHERE
    	 status in ('publish','published')
    	 AND
    	 is_assign='1'
    	 ";	    	
    	 if ($res=$db_ext->rst($stmt)){    	 	
    	 	 foreach ($res as $val) {
    	 	 	$lang[$val['lang_id']]=$val['country_code'];
    	 	 }    	 	 
    	 	 return $lang;
    	 }    
    	 return false;
    }
    
    public function jsLanguage()
    {
    	$js_lang=array(
		  'WishList'=>Yii::t("default","WishList"),
		  "RMitem"=>Yii::t("default","Remove this item"),
		  "InvalidQuantity"=>Yii::t("default","Invalid Quantity"),
		  "cookingRef"=>Yii::t("default","Please select your cooking Preference"),
		  "itemSize"=>Yii::t("default","Please Select item size"),
		  "cartEmpty"=>Yii::t("default","Your cart is empty"),
		  "areYouSure"=>Yii::t("default","Are you sure"),
		  "wishistEmpty"=>Yii::t("default","Your Wishlist is empty"),
		  "rmItemWishList"=>Yii::t("default","Remove this item in your wishlist?"),
		  "addToCart"=>Yii::t("default","Add to cart"),
		  "processing"=>Yii::t("default","processing"),
		  "errorMsg1"=>Yii::t("default","ERROR: Something went wrong."),
		  "addRecentOrder"=>Yii::t("default","Add your recent order to cart"),  
		  "loginOk"=>Yii::t("default","Login Successful."),  
		  'minOrderMsg'=>Yii::t("default","Sorry the minimum order amount is"),
		  'voucherCodeRequired'=>Yii::t("default","Invalid Discount Code"),
		  'removeVoucher'=>Yii::t("default","Are you sure?"),
		  'multiError'=>Yii::t("default","Sorry but you can only select "),
		  'Hour'=>Yii::t("default","Hour"),
    	  'Minute'=>Yii::t("default","Minute")
		);
		return $js_lang;
    }

    public function jsLanguageAdmin()
    {
    	return array(
    	  "deleteWarning"=>Yii::t("default","You are about to permanently delete the selected items.\n'Cancel' to stop, 'OK' to delete.?"),
    	  "checkRowDelete"=>Yii::t("default","Please check on of the row to delete."),
    	  "removeFeatureImage"=>Yii::t("default","Remove featured image"),
    	  "lastTotalSales"=>Yii::t("default","Last 30 days Total Sales"),
    	  "lastItemSales"=>Yii::t("default","Last 30 days Total Sales By Item"),
    	  "NewOrderStatsMsg"=>Yii::t("default","New Order has been placed."),
    	  'Hour'=>Yii::t("default","Hour"),
    	  'Minute'=>Yii::t("default","Minute"),
    	  
    	  "tablet_1"=>Yii::t("default","No data available in table"),
    	  "tablet_2"=>Yii::t("default","Showing _START_ to _END_ of _TOTAL_ entries"),
    	  "tablet_3"=>Yii::t("default","Showing 0 to 0 of 0 entries"),
    	  "tablet_4"=>Yii::t("default","(filtered from _MAX_ total entries)"),
    	  "tablet_5"=>Yii::t("default","Show _MENU_ entries"),
    	  "tablet_6"=>Yii::t("default","Loading..."),
    	  "tablet_7"=>Yii::t("default","Processing..."),
    	  "tablet_8"=>Yii::t("default","Search:"),
    	  "tablet_9"=>Yii::t("default","No matching records found"),
    	  "tablet_10"=>Yii::t("default","First"),
    	  "tablet_11"=>Yii::t("default","Last"),
    	  "tablet_12"=>Yii::t("default","Next"),
    	  "tablet_13"=>Yii::t("default","Previous"),
    	  "tablet_14"=>Yii::t("default",": activate to sort column ascending"),
    	  "tablet_15"=>Yii::t("default",": activate to sort column descending"),
    	);
    }   
    
    public function checkTableStructure($table_name='')
    {
    	$db_ext=new DbExt;
    	$stmt=" SHOW COLUMNS FROM {{{$table_name}}}";	    	
    	if ($res=$db_ext->rst($stmt)){    		
    		return $res;
    	}
    	return false;    
    }  
    
    public function isTableExist($table_name='')
    {
    	$db_ext=new DbExt;
    	$stmt="SHOW TABLE STATUS LIKE '{{{$table_name}}}'";	
    	if ($res=$db_ext->rst($stmt)){
    		return true;
    	}
    	return false;    
    }            
    
    public function decimalPlacesList()
    {
    	$numbers='';
    	for ($x=0; $x<=10; $x++) {            
    		$numbers[$x]=$x;
    	} 
    	return $numbers;
    }
    
    public function limitText($text='',$limit=100)
    {
    	if ( !empty($text)){
    		return substr($text,0,$limit)."...";
    	}    
    	return ;    	
    }
    
    public function orderStatusList($aslist=true)
    {
    	$list='';
    	if ($aslist){
    	    $list[]=Yii::t("default","Please select");    	
    	}
    	$db_ext=new DbExt;
    	$stmt="SELECT * FROM {{order_status}} ORDER BY stats_id";	
    	if ($res=$db_ext->rst($stmt)){
    		foreach ($res as $val) {    			
    			$list[$val['stats_id']]=$val['description'];
    		}
    		return $list;
    	}
    	return false;    
    }
    
    public function sendSMSNotification($client_info='')
    {
    	$Twilio=new Twilio;
    	if ( $sms_provider_info=$this->getSMSProvider()){    		
    		$sms_notification_msg=Yii::app()->functions->getOption("sms_notification_msg");    		
    		$sms_notification_msg=Yii::app()->functions->smarty("customer-name",$client_info[0]['fullname'],$sms_notification_msg);    		
	    	if ( $to=Yii::app()->functions->getOption("notify_mobile") ){    		
	    		$to=explode(",",$to);    			    		
	    		if (is_array($to) && count($to)>=1) {
	    			foreach ($to as $mobile_number) {	    				   
	    				if ( $sms_provider_info->sms_gateway_id =="twilio"){	    					
	    					$this->senSMSTwilio($mobile_number,$sms_notification_msg,$sms_provider_info);
	    				} else {	    					
	    					$this->sendSmsGlobal($mobile_number,$sms_notification_msg,$sms_provider_info);
	    				}
	    			}
	    		}
	    	}
    	}
    }    
    
    public function getSMSProvider()
    {
    	$sms_gateway_id='';$sender_id='';$api_username='';$api_password='';
		if ( $sms=Yii::app()->functions->getOption("sms_gateway")){	
			$sms=json_decode($sms);				
			return $sms;
		}
		return false;
    }
    
    public function senSMSTwilio($mobile='',$sms_message='',$provider_info='')
    {
    	$twilio=new Twilio;
    	$db_ext=new DbExt;    	
    	if ( is_object($provider_info) && !empty($sms_message) && !empty($mobile)){    		
			$twilio=new twilio;
			$twilio->_debug=false;
			$twilio->sid=$provider_info->api_username;
			$twilio->auth=$provider_info->api_password;
			$twilio->data['From']=$provider_info->sender_id;
			$twilio->data['To']=$mobile;
			$twilio->data['Body']=$sms_message;
			if ($resp=$twilio->sendSMS()){
				//$msg=$twilio->getSuccessXML();				
				$msg="Successul";
			} else $msg=$twilio->getError();
			
			$params=array(
			   'provider'=>'twilio',
			   'sms_message'=>$sms_message,
			   'mobile'=>$mobile,
			   'response'=>$msg,
			   'date_created'=>date('c'),
			   'ip_address'=>$_SERVER['REMOTE_ADDR']
			);
			$db_ext->insertData("{{sms_logs}}",$params);
    	}
    	if ( $msg=="Successul"){    		
    		$this->sms_msg=$msg;
    		return true;
    	}
    	$this->sms_msg=$msg;
    	return false;
    }
    
    public function sendSmsGlobal($mobile='',$sms_message='',$provider_info='')
    {
    	$db_ext=new DbExt;
    	$msg1='';
    	if ( is_object($provider_info) && !empty($sms_message) && !empty($mobile)){    		
			$abs_smsglobal=new SMSGlobal;
			$abs_smsglobal->_debug=false;
			$abs_smsglobal->_smsuser=$provider_info->api_username;
			$abs_smsglobal->_smspass=$provider_info->api_password;
			$abs_smsglobal->_sms_url="http://www.smsglobal.com/http-api.php";
			$abs_smsglobal->_smssender=$provider_info->sender_id;
			if ($resp=$abs_smsglobal->sendSMS_HTTPOST($mobile,$sms_message)){				
				$msg=$resp[0]." ".$resp[1];
				$msg1="Successul";
			} else $msg=$abs_smsglobal->get_error();			
			$params=array(
			   'provider'=>'smsglobal',
			   'sms_message'=>$sms_message,
			   'mobile'=>$mobile,
			   'response'=>$msg,
			   'date_created'=>date('c'),
			   'ip_address'=>$_SERVER['REMOTE_ADDR']
			);
			$db_ext->insertData("{{sms_logs}}",$params);
    	}
    	
    	if ( $msg1=="Successul"){
    		$this->sms_msg=$msg;
    		return true;
    	}
    	$this->sms_msg=$msg;
    	return false;
    }
    
    public function sendEmailSMTP($client_email,$from,$subject,$content)
    {    	
    	    	
    	require_once 'PHPMailer/PHPMailerAutoload.php';
    	
        $sme_smtp_authentication=yii::app()->functions->getOption("sme_smtp_authentication");
        $sme_smtp_encryption=yii::app()->functions->getOption("sme_smtp_encryption");
        $sme_smtp_host=yii::app()->functions->getOption("smtp_host");
        $sme_smtp_username=yii::app()->functions->getOption("sme_smtp_username"); 
        $sme_smtp_password=yii::app()->functions->getOption("sme_smtp_password");
                
        $sme_smtp_encryption=yii::app()->functions->getOption("sme_smtp_encryption");               
        $sme_smtp_port=yii::app()->functions->getOption("sme_smtp_port");
        
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();     
		$mail->Host = $sme_smtp_host;
		if ($sme_smtp_authentication==2){		            											
		    $mail->SMTPAuth = true;                          
		}						
		$mail->Username = $sme_smtp_username;
		$mail->Password = $sme_smtp_password;
		if ($sme_smtp_encryption!="no"){		               							
		   $mail->SMTPSecure = $sme_smtp_encryption;
		}
		$mail->Port = $sme_smtp_port;//465;
		$sme_letter_sender=  $from;
        if (!empty($sme_letter_sender)){
            $mail->setFrom($sme_letter_sender);
        } 
		$mail->addAddress($client_email);  
		$mail->WordWrap = 50;  
		$mail->isHTML(true);     
		
		$mail->Subject = $subject;
		$mail->Body    = $content;
        
        if(!$mail->send()) {
            $stats_msg='Mailer Error: ' . $mail->ErrorInfo;                           
            return false;
        } else $stats_msg="Successful";	                            	              
        return true;          
    } /*END SMTP*/
    
    public function orderStatusHasRef($stats_id='')
    {
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	       {{order}}
    	       WHERE
    	       stats_id='".$stats_id."'
    	       LIMIT 0,1
    	";    	
    	if ($res=$db_ext->rst($stmt)){
    		return true;
    	}
    	return false;
    }
    
    public function formatAsCSS($data='')
    {    	
    	$x=0;
    	$css="";
    	if (is_array($data) && count($data)>=1){
    		foreach ($data as $val) {    			
    			if ($x>=1){    			
    				if ( $x==1){
    					$css.="font-family:".$val.";";
    				} elseif ($x==2){
    					$css.=!empty($val)?"font-size:".$val."px;":"";
    				} elseif ($x==3){
    					$css.=!empty($val)?"padding:".$val."px;":'';
    				} elseif ($x==4){
    					$css.=!empty($val)?"color:".$val.";":'';
    				}
    			}    		
    			$x++;
    		}    		
    	}
    	return $css;
    }    
    
    public function getEventList($active=false)
    {
    	$where='';
    	if ( $active ){
    	   $where="WHERE status in ('publish','published')";
    	}
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	       {{events}}
    	       $where
    	       ORDER BY event_id DESC    	        	      
    	";    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }
    
    public function getEventListByID($event_id='')
    {
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	       {{events}}
    	       WHERE
    	       event_id ='$event_id'    	       
    	       LIMIT 0,1
    	";    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }
    
    public function cancelPaypalOrder($token='')
    {
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	{{paypal_checkout}}
    	WHERE
    	token='$token'
    	LIMIT 0,1
    	";
    	if ($res=$db_ext->rst($stmt)){    		
    		$order_id=$res[0]['order_id'];    		
    		$params=array('stats_id'=>2);    		
    		$db_ext->updateData("{{order}}",$params,'order_id',$order_id);
    	}
    }
    
    public function jsLanguageValidator()
    {
    	$js_lang=array(
		  'requiredFields'=>Yii::t("default","You have not answered all required fields"),
		  'groupCheckedTooFewStart'=>Yii::t("default","Please choose at least"),
		  'badEmail'=>Yii::t("default","You have not given a correct e-mail address"),
		);
		return $js_lang;
    }
    
    public function getPagesList($active=false,$order='page_id',$sort='DESC')
    {
    	$where='';
    	if ( $active ){
    	   $where="WHERE status in ('publish','published')";
    	}
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	       {{pages}}
    	       $where
    	       ORDER BY $order $sort    	        	      
    	";        	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }
    
    public function getPagesActive($assign_menu=1)
    {
    	$db_ext=new DbExt; 
    	$menu_page_id=Yii::app()->functions->getOption("menu_page_id");
		if ( !empty($menu_page_id)){
			$menu_page_id=json_decode($menu_page_id);
		}		
		$ids='';
		if (is_array($menu_page_id) && count($menu_page_id)>=1){
			foreach ($menu_page_id as $id) {
				$ids.="'$id',";
			}
			
			if ( $assign_menu==100){
				$and ="";
			} else $and =" AND assign_menu='$assign_menu'";			
			
			$ids=!empty($ids)?substr($ids,0,-1):"";			
			$stmt="SELECT * FROM
			{{pages}}
			WHERE
			page_id in ($ids)
			AND status in ('publish','published')
			$and
			ORDER BY sequence ASC
			";			
			if ($res=$db_ext->rst($stmt)){			
    		    return $res;
    	    }
		}
		return false;
    }
    
    public function getPagesByID($page_id='')
    {
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	       {{pages}}
    	       WHERE
    	       page_id='$page_id'
    	       LIMIT 0,1
    	";    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }    
    
    public function getPagesBySlug($page_id='')
    {    	
    	$data=$_GET;    	    
    	if (is_array($data) && count($data)>=1){
    		$data=array_flip($data);    	
    	    $page_id=$data[''];
    	}        	
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	       {{pages}}
    	       WHERE
    	       friendly_url='$page_id'
    	       LIMIT 0,1
    	";    	    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }        
    
    public function createUniqueFriendlyUrl($link='',$table='')
    {
    	$friendly_url=clean_string(strtolower($link));
    	$db_ext=new DbExt;
    	$stmt="SELECT COUNT(*) as total FROM
    	$table
    	WHERE
    	friendly_url='$friendly_url'
    	 ";    	
    	if ( $res=$db_ext->rst($stmt)){    		
    		$total=$res[0]['total'];
    	} else $total=0;
    	
    	if ( $total<=0){
    		return $friendly_url;
    	} else return $friendly_url.$total;
    }
    
    public function voucherDetailsById($voucher_id='')
    {
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	       {{voucher_list}}
    	       WHERE
    	       voucher_id='$voucher_id'    	       
    	       ORDER BY voucher_code ASC
    	";    	    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }        
    
    public function voucherDetailsByIdWithClient($voucher_id='')
    {
    	$db_ext=new DbExt;    	
    	$stmt="SELECT a.*,
               (
				select fullname
				from
				{{client}}
				where
				client_id=a.client_id
			   ) as fullname
    	       FROM
    	       {{voucher_list}} a
    	       WHERE
    	       voucher_id='$voucher_id'    	       
    	       ORDER BY voucher_code ASC
    	";    	    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }            
    
    public function getVoucherCode($voucher_code='')
    {
    	$db_ext=new DbExt;    	
    	$stmt="SELECT * FROM
    	       {{voucher_list}}
    	       WHERE
    	       voucher_code='$voucher_code'    	       
    	       LIMIT 0,1
    	";    	    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    } 
    
    public function getVoucherCodeActive($voucher_code='')
    {
    	$db_ext=new DbExt;    	    	
    	$stmt="SELECT a.*,b.amount,b.status,b.voucher_type,
    	       (
    	       select count(*)
    	       from
    	       {{order}}
    	       where
    	       voucher_code='".$voucher_code."'
    	       AND
    	       total_w_tax>'1'
    	       ) as total_used
    	       FROM
    	       {{voucher_list}} a, {{voucher}} b
    	       WHERE
    	       a.voucher_id=b.voucher_id
    	       AND
    	       a.voucher_code='$voucher_code'    	       
    	       LIMIT 0,1
    	";    	    	
    	if ($res=$db_ext->rst($stmt)){
    		return $res[0];
    	}
    	return false;
    }        
    
    
    public function voucherType()
    {
    	return array(
    	  'fixed amount'=>Yii::t("default","fixed amount"),
    	  'percentage'=>Yii::t("default","percentage")
    	);
    }       
    
    public function hasAccessMenu($tag='')
    {
    	$user_type=$this->getAdmiUserType();
    	if ( $user_type == "" || $user_type =="admin" ){
    		return true;
    	}    
    	$user_access=$this->getAdminAccess();
    	if (in_array($tag,(array)$user_access)){
            return true;
    	}    	
    	return false;
    }
    
    public function adminMenu()
    {    	
    	return  array(         
         'activeCssClass'=>'active',         
        'items'=>array(
            array('tag'=>"home",'label'=>Yii::t("default","Home"), 'url'=>array('/admin/home'),'itemOptions'=>array('class'=>'glyphicon glyphicon-home') ),
            
            array('visible'=>$this->hasAccessMenu("food-category"),'tag'=>"food-category",'label'=>Yii::t("default",'Food Category'), 'url'=>array('admin/category'),
                 'visible'=>Yii::app()->functions->hasAccessMenu('food-category'),
                 'itemOptions'=>array('class'=>'fa fa-list'),'items'=>array(                
            )),
            
            array('visible'=>$this->hasAccessMenu("food-item"),'tag'=>"food-item", 'label'=>Yii::t("default",'Food Item'), 'url'=>array('admin/item'), 
             'itemOptions'=>array('class'=>'fa fa-list'),
             'items'=>array(                
            )),
            
            array('visible'=>$this->hasAccessMenu("addon-cat"),'tag'=>"addon-cat",'label'=>Yii::t("default",'AddOn Category'), 'url'=>array('admin/subcategory'),
             'itemOptions'=>array('class'=>'fa fa-list'),
             'items'=>array(                
            )),
            
            array('visible'=>$this->hasAccessMenu("addon-item"),'tag'=>"addon-item",'label'=>Yii::t("default",'AddOn Item'), 'url'=>array('admin/subcategoryitem'), 
            'itemOptions'=>array('class'=>'fa fa-list'),
            'items'=>array(            
            )),
            
            array('visible'=>$this->hasAccessMenu("other-item"),'tag'=>"other-item",'label'=>Yii::t("default",'Other Item'),
            '', 'itemOptions'=>array('class'=>'fa fa-list'), 'items'=>array(
                array('visible'=>$this->hasAccessMenu("size"),'tag'=>"size",'label'=>Yii::t("default",'Size'), 'url'=>array('admin/otheritemsize')), 
                
                array('visible'=>$this->hasAccessMenu("cooking-ref"),'tag'=>"cooking-ref",'label'=>Yii::t("default",'Cooking Reference'), 'url'=>array('admin/cookingref')), 
                
                array('visible'=>$this->hasAccessMenu("multi-options"),'tag'=>"multi-options",'label'=>Yii::t("default",'multi options'), 'url'=>array('admin/multioptions')), 
            )),
            
            array('visible'=>$this->hasAccessMenu("store-settings"),'tag'=>"store-settings",'label'=>Yii::t("default",'Store Settings'),'itemOptions'=>array('class'=>'fa fa-cutlery'), 'url'=>array('admin/settings')  ),

            
            array('visible'=>$this->hasAccessMenu("receipt"),'tag'=>"receipt",'label'=>Yii::t("default",'Receipt Settings'),
              'itemOptions'=>array('class'=>'fa fa-file-text-o'), 'url'=>array('admin/receipt-settings'),
            ),
            
            array('visible'=>$this->hasAccessMenu("forgotpass"),'tag'=>"receipt",'label'=>Yii::t("default",'Forgot Password Template'),
              'itemOptions'=>array('class'=>'fa fa-file-text-o'), 'url'=>array('admin/forgotpassword'),
            ),
            
            array('visible'=>$this->hasAccessMenu("mail-settings"),'tag'=>"mail-settings",'label'=>Yii::t("default","Mail & SMTP Settings"),
            'itemOptions'=>array('class'=>'fa fa-envelope-o'), 'url'=>array('admin/smstpsettings')  ),
            
            
            array('visible'=>$this->hasAccessMenu("contact-settings"),'tag'=>"contact-settings",'label'=>Yii::t("default",'Contact Settings'),
            'itemOptions'=>array('class'=>'fa fa-envelope-o'), 'url'=>array('admin/contact-settings')  ),
                        
            array('visible'=>$this->hasAccessMenu("payment-gateway"),'tag'=>"payment-gateway",'label'=>Yii::t("default",'Payment Gateway'),
            'itemOptions'=>array('class'=>'fa fa-usd'), 'items'=>array(
                array('tag'=>"paypal",'label'=>Yii::t("default","Paypal"), 'url'=>array('admin/paypal')),
                array('tag'=>"braintree",'label'=>Yii::t("default","CreditCard"), 'url'=>array('admin/braintree')),
                array('tag'=>"braintree",'label'=>Yii::t("default","Stripe"), 'url'=>array('admin/stripe')),
            )),
            
            array('visible'=>$this->hasAccessMenu("social-settings"),'tag'=>"social-settings",'label'=>Yii::t("default",'Social Settings'),'itemOptions'=>array('class'=>'fa fa-facebook-square'),
            'url'=>array('admin/social-settings')  ),
                     
            array('visible'=>$this->hasAccessMenu("manage-layout"),'tag'=>"manage-layout",'label'=>Yii::t("default",'Manage Layout'),
            '', 'itemOptions'=>array('class'=>'fa fa-list'), 'items'=>array(                
                array('visible'=>$this->hasAccessMenu("themes"),'tag'=>"themes",'label'=>Yii::t("default",'Themes'), 'url'=>array('admin/layoutthemes')),
                
                array('visible'=>$this->hasAccessMenu("menu-layout"),'tag'=>"menu-layout",'label'=>Yii::t("default",'Menu layout'), 'url'=>array('admin/layoutmenu')), 
                
                array('visible'=>$this->hasAccessMenu("add-text-image"),'tag'=>"add-text-image",'label'=>Yii::t("default",'Add Text & Image'), 'url'=>array('admin/managelayout'))                
                
            )),
            
            array('visible'=>$this->hasAccessMenu("manage-translation"),'tag'=>"manage-translation",'label'=>Yii::t("default",'Manage Translation'),'itemOptions'=>array('class'=>'fa fa-flag'),
            'url'=>array('admin/translationsettings')  ),
            
            array('visible'=>$this->hasAccessMenu("manage-currency"),'tag'=>"manage-currency",'label'=>Yii::t("default",'Manage Currency'),'itemOptions'=>array('class'=>'fa fa-usd'),
            'url'=>array('admin/currency-settings')  ),
            
            array('visible'=>$this->hasAccessMenu("manage-order-stats"),'tag'=>"manage-order-stats",'label'=>Yii::t("default",'Manage Order Status'),'itemOptions'=>array('class'=>'fa fa-file-text'),
            'url'=>array('admin/orderstatssettings')  ),
                                    
            array('visible'=>$this->hasAccessMenu("notification"),'tag'=>"notification",'label'=>Yii::t("default",'Notification'),'itemOptions'=>array('class'=>'fa fa-bell-o'), 'items'=>array(
                array('visible'=>$this->hasAccessMenu("alter-notification"),'tag'=>"alter-notification",'label'=>Yii::t("default",'Alert Notification'),'url'=>array('admin/alertsettings')),
                
                array('visible'=>$this->hasAccessMenu("sms-notification"),'tag'=>"sms-notification",'label'=>Yii::t("default",'SMS Notification Settings'),'url'=>array('admin/smssettings')),
                
                array('visible'=>$this->hasAccessMenu("sms-logs"),'tag'=>"sms-logs",'label'=>Yii::t("default",'SMS Notification Logs'),'url'=>array('admin/smslogs')),  
            )),
                        
            array('visible'=>$this->hasAccessMenu("manage-events"),'tag'=>"manage-events",'label'=>Yii::t("default",'Manage Events'),'itemOptions'=>array('class'=>'fa fa-file-text'), 'items'=>array(
                array('visible'=>$this->hasAccessMenu("add-event"),'tag'=>"add-event",'label'=>Yii::t("default",'Add Event'),'url'=>array('admin/events')),
                array('visible'=>$this->hasAccessMenu("event-list"),'tag'=>"event-list",'label'=>Yii::t("default",'Event List'),'url'=>array('admin/eventslist')),                
            )),
            
            array('visible'=>$this->hasAccessMenu("manage-pages"),'tag'=>"manage-pages",'label'=>Yii::t("default",'Manage Pages'),'itemOptions'=>array('class'=>'fa fa-file-text'), 'items'=>array(
                array('visible'=>$this->hasAccessMenu("add-page"),'tag'=>"add-page",'label'=>Yii::t("default",'Add Page'),'url'=>array('admin/addpage')),
                array('visible'=>$this->hasAccessMenu("page-list"),'tag'=>"page-list",'label'=>Yii::t("default",'Page List'),'url'=>array('admin/pagelist')), 
                array('visible'=>$this->hasAccessMenu("page-menu"),'tag'=>"page-menu",'label'=>Yii::t("default",'Page Menu'),'url'=>array('admin/pageMenu')),                
            )),
            
            array('visible'=>$this->hasAccessMenu("reservation-settings"),'tag'=>"reservation-settings",'label'=>Yii::t("default",'Reservation Settings'),'itemOptions'=>array('class'=>'fa fa-calendar'),
            'url'=>array('admin/reservation')),
            
            array('visible'=>$this->hasAccessMenu("seo-tools"),'tag'=>"seo-tools",'label'=>Yii::t("default",'SEO Tools'),'itemOptions'=>array('class'=>'fa fa-files-o'), 'items'=>array(
                array('visible'=>$this->hasAccessMenu("title-metas"),'tag'=>"title-metas",'label'=>Yii::t("default",'Title & Metas'),'url'=>array('admin/seometas'))                
            )),
            
            array('visible'=>$this->hasAccessMenu("manage-voucher"),'tag'=>"manage-voucher",'label'=>Yii::t("default",'Manage Voucher'),'itemOptions'=>array('class'=>'fa fa-files-o'), 'url'=>array('admin/voucher')  ),
            
            array('visible'=>$this->hasAccessMenu("reports"),'tag'=>"reports",'label'=>Yii::t("default",'Reports'),'itemOptions'=>array('class'=>'fa fa-files-o'), 'items'=>array(
            
                array('visible'=>$this->hasAccessMenu("registered-user"),'tag'=>"registered-user",'label'=>Yii::t("default",'Registered User'),'url'=>array('admin/rpt-reg-user')),                 
                               
                array('visible'=>$this->hasAccessMenu("sales-report"),'tag'=>"sales-report",'label'=>Yii::t("default",'Sales Report'), 'url'=>array('admin/rpt-sales-report')),               
                
                array('visible'=>$this->hasAccessMenu("sales-rpt-item"),'tag'=>"sales-rpt-item",'label'=>Yii::t("default",'Sales Report By Item'), 'url'=>array('admin/rpt-sales')),                 
                
                array('visible'=>$this->hasAccessMenu("sales-summary"),'tag'=>"sales-summary",'label'=>Yii::t("default",'Sales Summary Report'), 'url'=>array('admin/rpt-sales-summary')),                 
                
            )),
            array('visible'=>$this->hasAccessMenu("user-management"),'tag'=>"user-management",'label'=>Yii::t("default",'User Management'),'itemOptions'=>array('class'=>'fa fa-user'),
            
            'url'=>array('admin/user-management')),
            array('tag'=>"logout",'label'=>Yii::t("default",'Logout'),'itemOptions'=>array('class'=>'fa fa-sign-out'),
             'url'=>array('admin/?logout=true'),'visible'=>Yii::app()->functions->isAdminLogin())
        ));
    }   
    
    public function userRole()
    {
    	return array(
    	 ''=>Yii::t("default","Please select"),
    	 'admin'=>"admin",
    	 "user"=>"User"
    	);
    }
    
    public function checkAcl()
    {
    	return true;
    }    
    
	public function getMultiOptionList()
	{
		$stmt="
		SELECT * FROM
		{{multi_options}}
		ORDER BY sequence ASC		
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			if ($this->data=="list"){
				foreach ($rows as $val) {									   
				   $data_feed[$val['multi_id']]=$val['multi_name'];
				}
                return $data_feed;
			} else return $rows;			
		}
		return FALSE;
	}	    
	
	public function ccExpirationMonth()
    {
    	$data='';
    	for ($i = 1; $i <= 12; $i++) {    		    		
    		$temp=$i;
    		if (strlen($i)==1){
    			$temp="0".$i;
    		}    		
    		$data[$temp]=$temp;
    	}
    	return $data;
    }
    
    public function ccExpirationYear()
    {
    	$data='';
    	$yr_now=date("Y");
    	for ($i = 0; $i <= 12; $i++) {    		    		    		
    		$yr=$yr_now+$i;
    		$data[$yr]=$yr;
    	}
    	return $data;
    }
    
    public function maskCardnumber($cardnumber='')
    {
    	if ( !empty($cardnumber)){
    		return substr($cardnumber,0,4)."XXXXXXXXX".substr($cardnumber,-4,4);
    	}
    	return '';
    }
    
	public function getCreditCardInfo($cc_id)
	{
		$stmt="
		SELECT * FROM
		{{client_cc}}
		WHERE
		cc_id='".$cc_id."'
		LIMIT 0,1
		";		
		$connection=Yii::app()->db;
		$rows=$connection->createCommand($stmt)->queryAll(); 		
		if (is_array($rows) && count($rows)>=1){
			return $rows[0];
		}
		return FALSE;
	}
	
	public function preApprovedStatus()
	{
		return array(
		  1=>Yii::t("default","Approved"),
		  2=>Yii::t("default","Reject")
		);
	}
	
	public function getPreApprovedSatus($status_id='')
	{
		$db_ext=new DbExt;    	
		$stmt="SELECT * FROM
		{{order}}
		WHERE
		order_id='$status_id'
		LIMIT 0,1
		";
		if ($res=$db_ext->rst($stmt)){
			return $res[0];
		}
		return false;
	}
	
    public function normalPrettyPrice($price='')
    {
    	if (is_numeric($price)){
		    return number_format($price,0,'.','');
	    }
	    return false;        
    }
}
/*END CLASS*/


/********************************************************************
   START FUNCTIONS
*********************************************************************/

if (!function_exists('dump')){
	function dump($data='')
	{
		echo "<pre>";print_r($data);echo "</pre>";
	}
}

function baseCurr()
{
	return yii::app()->functions->getCurrencyCode();
}

function notFound()
{
	echo ("<p class=\"not_found\">".Yii::t("default","Sorry but we cannot find what you are looking for")."</p>");
}

function to_json($data='')
{
	if(!empty($data)){
		$new_data=json_decode($data);
	} else $new_data='';
	return $new_data;
}

function keyAndVal($key='',$val='')
{	
	if (array_key_exists($key,(array)$val)){
		return $val[$key];
	} 
	return '';
}

function prettyPrice($price='')
{
	$decimal=yii::app()->functions->getOption('decimal_places');
	$decimal_separators=yii::app()->functions->getOption('decimal_separators');
	$thou_separator='';
	if (!empty($price)){
		if ($decimal==""){
			$decimal=2;
		}
		if ( $decimal_separators==1){
			$thou_separator=",";
		}		
		return number_format((float)$price,$decimal,".",$thou_separator);
	}	
	if ($decimal==""){
		$decimal=2;
	}	
	return number_format(0,$decimal,".",$thou_separator);
}

function unPrettyPrice($price='')
{
	return str_replace(",","",$price);
}


function getDistance($from='',$to='')
{
	$debug=false;
	$country_list=require_once "CountryCode.php";
	$country_code=yii::app()->functions->getOption('country_code');		
	$country_name='';
	
	if (array_key_exists($country_code,$country_list)){
		$country_name=$country_list[$country_code];
	} 
	if (!preg_match("/$country_name/i", $from)) {		
		$from.=" ".$country_name;
	}
	if (!preg_match("/$country_name/i", $to)) {		
		$to.=" ".$country_name;
	}	
	if ($debug){
	   dump($from);
	   dump($to);
	}
	$url="http://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($from)."&destinations=".urlencode($to)."&language=en-EN&sensor=false";		
	
	$data = file_get_contents($url);	
    $data = json_decode($data);              
    
    if ($debug){
	   dump($data);	   
	}
    
    if (is_object($data)){
    	if ($data->status=="OK"){    		    		
    		if ($data->rows[0]->elements[0]->status=="OK" ) {    			
    			return $data;
    		}    	    		
    	}
    }
    return FALSE;
}

function accountExist($email='')
{
	$stmt="
	SELECT * FROM
	{{client}}
	WHERE
	email='".$email."'
	LIMIT 0,1
	";	
	$connection=Yii::app()->db;
	$rows=$connection->createCommand($stmt)->queryAll();	
	if (is_array($rows) && count($rows)>=1){	
		return $rows;
	} else return FALSE;	
}

function isUserLoggedIn(){
	if (Yii::app()->functions->isUserLoggedIn()){
		return true;
	} else return false;
}

function display($is_login=FALSE)
{
	if ($is_login==FALSE){
		if (isUserLoggedIn()){
			return "style=\"display:none;\"";
		} else {
			return "style=\"display:block;\"";
		}
	} else {
		if (isUserLoggedIn()){
			return "style=\"display:block;\"";
		} else {
			return "style=\"display:none;\"";
		}
	}
}

function remove_html_comments($content = '') {
	return preg_replace('/<!--(.|\s)*?-->/', '', $content);
}

function clean_string($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}



function generateCouponCode($length = 8) {
  $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $ret = '';
  for($i = 0; $i < $length; ++$i) {
    $random = str_shuffle($chars);
    $ret .= $random[0];
  }
  return $ret;
}

function getOrderCart($payment_type='',$trans_type='')
{
	/*dump($payment_type);
	dump($trans_type);*/
	$ajax=new AjaxSites();
	$item=$ajax->loadCartItem();
	//dump($ajax->code);	
	if ( $ajax->code==1){
		$details=$ajax->details['complex_data'];
		//dump($details);
		$total=$details['total']+$details['total_addon']+$details['convenience_charge']-$details['less_voucher'];
		//dump($total);
		if ( $trans_type=="delivery"){
			$delivery_charges=yii::app()->functions->getOption("delivery_charges");
			$total=$total+$delivery_charges;
		}
		$tax_amount=0;
		if (is_numeric($details['tax'])){
			$tax_amount=$total*($details['tax']/100);
		}	
		//dump($tax_amount);
		$total_wtax=$total+$tax_amount;
		return $total_wtax;
	} 
	return false;
}

function t($text='')
{
	return Yii::t("default",$text);
}