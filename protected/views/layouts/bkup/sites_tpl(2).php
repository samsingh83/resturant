<?php yii::app()->functions->sessionInit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<?php if (!isset($_GET['noscript'])):?>
<link rel="shortcut icon" href="<?php echo  Yii::app()->request->baseUrl; ?>/favicon.ico" />

<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/alert/jquery.alerts.css" rel="stylesheet" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />

<!--START BOOTSTRAP-->
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!--END BOOTSTRAP-->

<!--START Google FOnts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Podkova|Rosario|Abel|PT+Sans|Source+Sans+Pro:400,600,300|Roboto' rel='stylesheet' type='text/css'>
<!--END Google FOnts-->
    
<!--START BXSLIDER CSS-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/bxslider/jquery.bxslider.css" rel="stylesheet" />
<!--END BXSLIDER CSS-->

<!--FONT AWESOME-->
<!--<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />-->
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<!--END FONT AWESOME-->

<!--UIKIT-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/uikit.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/uikit.gradient.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/addons/uikit.addons.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/addons/uikit.gradient.addons.min.css" rel="stylesheet" />
<!--UIKIT-->

<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/sites.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/sites-responsive.css" rel="stylesheet" />
<?php endif;?>

</head>

<?php if ( Yii::app()->functions->getOption("layout_themes") == 7):?>
<style type="text/css">
body.layout_themes7 .header{background:<?php echo Yii::app()->functions->getOption("custom_colors")?>;}</style>
<?php endif;?>

<body class="layout_themes<?php echo Yii::app()->functions->getOption("layout_themes"); ?>">

<div id="mobile_menu_wrap" class="uk-offcanvas">
    <div class="uk-offcanvas-bar">
       <ul class="uk-nav uk-nav-offcanvas" data-uk-nav>       
        <li class="uk-nav-header">
          <a href="<?php echo Yii::app()->request->baseUrl;?>">
           <?php echo yii::app()->functions->getOption('store_name')?>
		  </a>
		</li>
		
		<li><a href="<?php echo Yii::app()->request->baseUrl."/store";?>">
		<i class="glyphicon glyphicon-home"></i> Home
		</a>
		</li>		
				
		<li>
		<a href="<?php echo Yii::app()->request->baseUrl;?>/store/contact-us" class="contact">
		<i class="glyphicon glyphicon-envelope"></i> <?php echo Yii::t('default',"Contact")?></a>
		</li>
		
		<li>
		<a href="<?php echo Yii::app()->request->baseUrl;?>/store/recent-order" class="profile"><i class="glyphicon glyphicon-list-alt"></i> <?php echo Yii::t('default',"My Orders")?></a>
		</li>
		
		<li>
		<a href="<?php echo Yii::app()->request->baseUrl;?>/store/wishlist"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo Yii::t('default',"WishList")?></a>
		</li>	
				
		<?php if (Yii::app()->functions->isUserLoggedIn()):?>
		<li>
		<a href="<?php echo Yii::app()->request->baseUrl;?>/store/profile" class="profile"><i class="glyphicon glyphicon-user"></i> <?php echo Yii::t('default',"Profile")?></a>
		</li>
				 
		<li>
		<a href="<?php echo Yii::app()->request->baseUrl;?>/store/logout" class="logout"><i class="glyphicon glyphicon-log-out"></i> <?php echo Yii::t('default',"Logout")?></a>
		</li>		 
		<?php else :?>						
		<li>
		<a href="javascript:;" data-toggle="modal" data-target=".pop_login"><i class="glyphicon glyphicon-log-in"></i> <?php echo Yii::t('default',"Login")?>
		</a>
		</li>		  
		<?php endif;?>
		
				
       </ul>
    </div>
</div>

<div class="header" data-uk-sticky>
	<div class="main">	
	    <div class="left mobile_menu_handle">
	      <a href="#mobile_menu_wrap" data-uk-offcanvas ><i class="fa fa-bars"></i></a>
	    </div>
		<div class="left">		 
		
		 <?php $store_logo=yii::app()->functions->getOption("store_logo");?>
		 <?php if (!empty($store_logo)):?>
		 <img class="store_logo" src="<?php echo Yii::app()->request->baseUrl."/upload/".$store_logo;?>?>" alt="" title=""> 
		 <?php endif;?>
		
		 <h1 class="site_title left">
		 <a href="<?php echo Yii::app()->request->baseUrl;?>">
		 <?php echo yii::app()->functions->getOption('store_name')?>
		 </a>
		 </h1>
		</div>		
		<div class="right">
			  <a href="javascript:;" class="cart_handle">
			  <div class="cart">
			    <span class="cart_item">0</span>			      
			  </div> <!--cart-->
			  </a>
			  <div class="cart_details_wrap">
			      <div class="cart_details_wrap_inner">
			      <ul>			    
			      </ul>			   			      
			      <div class="cart_input_block">
			        <a href="<?php echo Yii::app()->request->baseUrl;?>/store/cart" class="btn_grey"><?php echo Yii::t('default',"CART")?></a>
			        <!--<a href="javascript:;" id="checkout" class="btn_grey"  data-toggle="modal" data-target=".checkout" >
			        <?php echo Yii::t('default',"CHECKOUT")?></a>-->
			        <a href="javascript:;" id="checkout" class="btn_grey">
			        <?php echo Yii::t('default',"CHECKOUT")?></a>
			      </div>			         
			      </div>
			  </div> <!--cart_details_wrap-->
		</div>
				
		<div class="right top_nav">
		 <ul>		 
		  <li class="glyphicon glyphicon-home"><a href="<?php echo Yii::app()->request->baseUrl."/store";?>"><?php echo Yii::t('default',"Home")?></a></li>
		  
		  <li class="glyphicon glyphicon-plus-sign"><a href="javascript:;" class="favorites"><?php echo Yii::t('default',"WishList")?></a>
		   <div class="wish_list_wrap" style="display:none;">		     		     
		   </div> <!--END wish_list_wrap-->
		  </li>	
		   		   
		  <li class="glyphicon glyphicon-envelope"><a href="<?php echo Yii::app()->request->baseUrl;?>/store/contact-us" class="contact"><?php echo Yii::t('default',"Contact")?></a></li>
		  <?php if (Yii::app()->functions->isUserLoggedIn()):?>
		  <li class="glyphicon glyphicon-list-alt"><a href="<?php echo Yii::app()->request->baseUrl;?>/store/recent-order" class="profile"><?php echo Yii::t('default',"My Orders")?></a></li>
		  
		  <li class="glyphicon glyphicon-user"><a href="<?php echo Yii::app()->request->baseUrl;?>/store/profile" class="profile"><?php echo Yii::t('default',"Profile")?></a></li>
		  <li class="glyphicon glyphicon-log-out"><a href="<?php echo Yii::app()->request->baseUrl;?>/store/logout" class="logout"><?php echo Yii::t('default',"Logout")?></a></li>		 
		  <?php else :?>
		  <li class="none glyphicon glyphicon-user"><a href="<?php echo Yii::app()->request->baseUrl;?>/store/profile" class="profile"><?php echo Yii::t('default',"Profile")?></a></li>
		  <li class="none glyphicon glyphicon-log-out">
		  <a href="<?php echo Yii::app()->request->baseUrl;?>/store/logout" class="logout"><?php echo Yii::t('default',"Logout")?></a>
		  </li>		 
		  <li class="glyphicon glyphicon-log-in"><a href="javascript:;" data-toggle="modal" data-target=".pop_login"><?php echo Yii::t('default',"Login")?></a></li>		  
		  <?php endif;?>
		  		  
		 </ul>
	    </div>	    
	    
		<div class="clear"></div>
	</div> <!--header-->
</div>

<div class="main_content">
	<div class="main">
	<div class="bread_crumb">
	  <?php
	  $breadcrumbs=Yii::app()->functions->breadcrumbs();	  
	  /*$this->widget('zii.widgets.CBreadcrumbs', array(
	    'links'=>array(
	        'Sample post'=>array('post/view', 'id'=>12),
	        'Edit',
	    ),
  	  ));*/	  
	  $this->widget('zii.widgets.CBreadcrumbs', array(
	    'homeLink'=>CHtml::link(Yii::t("default","Home"), array('/store')),
	    'links'=>$breadcrumbs	    
  	  )); 
	  ?>
	</div><!-- END bread_crumb-->
	<?php echo $content;?>
	</div>
</div>


<!--********************************************
   START SIDEPANEL
********************************************-->
<?php if (Yii::app()->functions->getOption("show_language_siderbar")):?>
<div class="sider_bar_wrap">
<a href="javascript:;" class="side_panel_handle"><i class="fa fa-arrow-circle-left"></i></a>
<div class="sider_bar_content">
    <h5><?php echo Yii::t("default","Choose your language")?></h5>
    <div class="lang_wrap">
    <a href="<?php echo Yii::app()->request->baseUrl;?>/store/?lang_id=10000"><?php echo Yii::app()->functions->getFlagByCode("US")?></a>    
     <?php if ($assign_lang=Yii::app()->functions->getAssignLanguage()):?>
     <?php foreach ($assign_lang as $lang_id=>$lang_country_code):?>     
		  <a href="<?php echo Yii::app()->request->baseUrl;?>/store/?lang_id=<?php echo $lang_id?>"><?php echo Yii::app()->functions->getFlagByCode($lang_country_code)?></a>    
     <?php endforeach;?>     
     <?php endif;?>
    </div> <!--END lang_wrap-->
</div> <!--END sider_bar_content-->
<div class="clear"></div>
</div> <!--END sider_bar_wrap-->
<?php endif;?>
<!--********************************************
   END SIDEPANEL
********************************************-->

<div class="modal fade checkout" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
         <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="mySmallModalLabel" class="modal-title"> <?php echo Yii::app()->name; ?></h4>
        </div>
        <div class="modal-body">
          <h3><?php echo Yii::t('default',"Delivery or Carryout")?>?</h3>
          <a class="btn_grey" href="<?php echo Yii::app()->request->baseUrl;?>/store/delivery"><?php echo Yii::t('default',"Delivery")?></a>
          <a class="btn_grey" href="<?php echo Yii::app()->request->baseUrl;?>/store/carryout"><?php echo Yii::t('default',"Carryout")?> </a>
          <div class="clear"></div>
        </div> <!--modal-body-->
    </div>
  </div>
</div>

<!--********************************************
   LOGIN
********************************************-->
<div class="modal fade pop_login" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
         <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="mySmallModalLabel" class="modal-title"><?php echo Yii::t("default","Login")?></h4>
        </div>
        <div class="modal-body">
           <form id="frm_login" class="frm_login" method="POST" onsubmit="return false;">
           <input type="hidden" name="action" value="login">
           <div class="input-group">
			<span class="input-group-addon"><?php echo Yii::t('default',"Username")?></span>
			<input type="text"  name="username" class="form-control" placeholder="<?php echo Yii::t('default',"Username")?>">
	       </div>
	       <div class="input-group">
			<span class="input-group-addon"><?php echo Yii::t('default',"Password")?></span>
			<input type="password"  name="password"  class="form-control" placeholder="<?php echo Yii::t('default',"Password")?>">
	       </div>
	       <input type="submit" id="submit" value="<?php echo Yii::t('default',"Login")?>"  class="mybtn buttonorange">	       
	       
	       <div class="more_login_option">
	       <p>
	       <?php echo Yii::t('default',"Don't have account? sign up")?><a href="<?php echo Yii::app()->request->baseUrl;?>/store/signup"> <?php echo Yii::t('default',"here")?></a>
	       </p>	
	       <p class="fb_login_wrap">
	       <?php if (yii::app()->functions->getOption('fb_flag')==1):?>
	       <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"><?php echo Yii::t('default',"Sign in with Facebook")?></fb:login-button>
	       <?php endif;?>
	       </p>
	       <i style="display:none;" class="login_loading_indicator fa fa-spinner fa-spin"></i>
	       </div>       
	       	       	       
	       <div class="clear"></div>
	       </form>
        </div> <!--modal-body-->
    </div>
  </div>
</div>
<!--********************************************
   END LOGIN
********************************************-->


<!--********************************************
   START MODE OF PAYMENT
********************************************-->
<?php $is_paypal_enabled=Yii::app()->functions->getOption("paypal_enabled"); ?>
<!--<button class="btn btn-primary" data-toggle="modal" data-target=".pop_mode_of_payment">Small modal</button>-->
<div class="modal fade pop_mode_of_payment" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="mySmallModalLabel" class="modal-title"><?php echo Yii::t('default',"Mode Of Payment")?></h4>
      </div>      
      <div class="modal-body">
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/cashondeliver" id="mod_payment_cod" class="btn btn-success">
       <?php echo Yii::t('default',"Cash On delivery")?>
       </a>
       <?php if ($is_paypal_enabled==1):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/paypalinit" id="mod_payment_paypal" class="btn btn-info">
       <?php echo Yii::t('default',"Paypal")?></a>
       <?php endif;?>
    </div> <!-- END modal-body-->
    </div> <!--END MODAL CONTENT-->        
  </div>
</div>
<!--********************************************
   END MODE OF PAYMENT
********************************************-->

<div class="footer">
  <div class="main">
  <div class="left" >
  <?php if ( yii::app()->functions->getOption("footer_store_name") ):?>
   <p><?php echo yii::app()->functions->getOption('footer_store_name')?>
  <?php else :?>
   <p><?php echo yii::app()->functions->getOption('store_name')?> &copy; 2014</p>   
  <?php endif;?>
   <div class="footer_address_wrap">
       <?php 
       $store_address=Yii::app()->functions->getOption("address");
       $store_phone=Yii::app()->functions->getOption("phone_number");
       $store_email=Yii::app()->functions->getOption("contact_email");
       ?>
	   <p>
	   <?php if (!empty($store_address)){echo $store_address;}?>   
	   <span>|</span>
	   <?php if (!empty($store_phone)):?>
	   <i class="fa fa-phone"></i> <?php echo $store_phone?>	   
	   <span>|</span>  
	   <?php endif;?>
	   <?php if (!empty($store_email)):?>
	   <i class="fa fa-envelope-o"></i> <?php echo $store_email?></p>
	   <?php endif;?>
   </div> <!--END footer_address_wrap-->
   <div class="clear"></div>
   
   
   <!--START store_hours_wrap-->
   <div class="store_hours_wrap">
   <?php 
   $stores_open_day=yii::app()->functions->getOption('stores_open_day');
   $stores_open_day=!empty($stores_open_day)?json_decode($stores_open_day):false;   
   /*$stores_open_start=yii::app()->functions->getOption('stores_open_start');
   $stores_open_end=yii::app()->functions->getOption('stores_open_end');*/
	$stores_open_am_start=yii::app()->functions->getOption('stores_open_am_start');
	$stores_open_am_end=yii::app()->functions->getOption('stores_open_am_end');
	$text_day=yii::app()->functions->getOption('text_day');
	if (!empty($stores_open_am_start)){
	    $stores_open_am_start=(array)json_decode($stores_open_am_start);
	}
	if (!empty($stores_open_am_end)){
	    $stores_open_am_end=(array)json_decode($stores_open_am_end);
	}
	if (!empty($text_day)){
	   $text_day=(array)json_decode($text_day);
	}
	
	$stores_open_pm_start=yii::app()->functions->getOption('stores_open_pm_start');
	$stores_open_pm_end=yii::app()->functions->getOption('stores_open_pm_end');
	if (!empty($stores_open_pm_start)){
	    $stores_open_pm_start=(array)json_decode($stores_open_pm_start);
	}
	if (!empty($stores_open_pm_end)){
	   $stores_open_pm_end=(array)json_decode($stores_open_pm_end);
	}	
	
	$text_day=yii::app()->functions->getOption('text_day');
	if (!empty($text_day)){
	    $text_day=(array)json_decode($text_day); 
    }    
   ?>
   <?php if ($stores_open_day || $stores_open_start):?>
   <div><i class="fa fa-home"></i>  <?php echo Yii::t("default","Store Hours Open:");?></div>
   <?php if (is_array($stores_open_day) && count($stores_open_day)>=1):?>
   <?php foreach ($stores_open_day as $val_day):?>
   <li>
     <i class="fa fa-chevron-circle-right"></i>
     <p class="day"><?php echo $val_day;?></p>
     <p>
     <?php 
     if (array_key_exists($val_day,$stores_open_am_start)){     	
     	if (!empty($stores_open_am_start[$val_day])){
     	   echo "( ".$stores_open_am_start[$val_day];
     	   echo " - ";
     	}
     }     
     if (array_key_exists($val_day,$stores_open_am_end)){     	
     	if (!empty($stores_open_am_end[$val_day])){
     	   echo $stores_open_am_end[$val_day];
     	   echo " )";
     	}
     }
     if (array_key_exists($val_day,$stores_open_pm_start)){     	
     	if (!empty($stores_open_pm_start[$val_day])){
	     	echo " / ( ";
	     	echo $stores_open_pm_start[$val_day];     	
	     	echo " - ";
     	}
     }
     if (array_key_exists($val_day,$stores_open_pm_end)){     	
     	if (!empty($stores_open_pm_end[$val_day])){
     	   echo $stores_open_pm_end[$val_day];
     	   echo " )";
     	}
     }
     if (array_key_exists($val_day,$text_day)){     	
     	if (!empty($text_day[$val_day])){
     	    echo " ,";
     	    echo $text_day[$val_day];     	
     	}
     }
     ?>
     </p>
     <div class="clear"></div>
   </li>
   <?php endforeach;?>
   <?php endif;?>
   <?php endif;?>
   </div>
   <!--END store_hours_wrap-->
   
   </div> <!--END LEFT-->
   <div class="right">
   <ul class="social_wrap">
	<?php if (yii::app()->functions->getOption('social_flag')==1):?>
		<?php if (yii::app()->functions->getOption('fb_page')!=""):?>		
		<li class="social_icon">
		<a target="_blank" href="<?php echo yii::app()->functions->getOption('fb_page')?>"><i class="fa fa-facebook-square"></i></a>
		</li>
		<?php endif;?>
		<?php if (yii::app()->functions->getOption('twitter_page')!=""):?>
		<li class="social_icon">
		<a target="_blank"  href="<?php echo yii::app()->functions->getOption('twitter_page')?>"><i class="fa fa-twitter-square"></i></a>
		</li>
		<?php endif;?>
		<?php if (yii::app()->functions->getOption('google_page')!=""):?>
		<li class="social_icon">
		<a target="_blank" href="<?php echo yii::app()->functions->getOption('google_page')?>"><i class="fa fa-google-plus-square"></i></a>
		</li>			
		<?php endif;?>		
	   <li class="social_icon social_last">&nbsp;</li>
	<?php endif;?>
	<div class="clear"></div>
   </ul>
   </div>
   <div class="clear"></div>
 </div> <!--END main-->
</div>
<!--END footer-->


<!--********************************************
   START PAGE FULL VIEW
********************************************-->
<div class="post_full_wrapper">
  <div class="full_nav_wrap">
     <div class="inner">
         <a href="javascript:;" class="back"><?php echo Yii::t("default","Back")?></a>         
         <i class="loader"></i>         
         <div class="right">						
			<h1 class="full_post_header" style="margin:0;"></h1>
         </div>
         <div class="clear"></div>
     </div>
  </div>
  <div class="post_full_content" >    
  </div>
</div>
<!--********************************************
   START PAGE FULL VIEW
********************************************-->


<input type="hidden" name="fb_app_id" id="fb_app_id" value="<?php echo yii::app()->functions->getOption('fb_app_id');?>">
<input type="hidden" name="minimum_order" id="store_min_order" value="<?php echo unPrettyPrice(yii::app()->functions->getOption('minimum_order'));?>">
<input type="hidden" name="store_cuurency_code" id="store_cuurency_code" value="<?php echo baseCurr();?>">

</body>

<?php if (!isset($_GET['noscript'])):?>

<?php 
$js_lang=Yii::app()->functions->jsLanguage();
?>

<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
var ajax_url='<?php echo Yii::app()->request->baseUrl;?>/store/ajax';
var sites_url='<?php echo Yii::app()->request->baseUrl;?>';
var js_lang=<?php echo json_encode($js_lang)?>;
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.38/jquery.form-validator.min.js"></script>

<!--BXSLIDER-->
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/bxslider/jquery.bxslider.min.js" type="text/javascript"></script>
<!--BXSLIDER-->

<?php if (Yii::app()->controller->getAction()->getId()=="ContactUs"):?>
<!--Google Maps-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<!--END Google Maps-->
<?php endif;?>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.ui.timepicker-0.0.8.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/alert/jquery.alerts.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/sites.js?ver=1" type="text/javascript"></script>  

<?php if (yii::app()->functions->getOption('fb_flag')==1):?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/fblogin.js?ver=1" type="text/javascript"></script>  
<?php endif;?>

<!--BOOSTRAP-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!--END BOOSTRAP-->

<!--UIKIT-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/uikit.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/notify.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/sticky.min.js"></script>
<!--UIKIT-->

<!--NICE SCROLL-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/jquery.nicescroll.min.js"></script>
<!--NICE SCROLL-->

<!--DIRECTIONAL EFFECT-->
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/directional/modernizr.custom.97074.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/directional/jquery.hoverdir.js"></script>
<!--END DIRECTIONAL EFFECT-->

<?php endif;?>

<?php if (isset($_GET['msg'])):?>
<input type="hidden" id="msg_get" class="msg_get"  value="<?php echo $_GET['msg']?>" >
<?php endif;?>


</html>