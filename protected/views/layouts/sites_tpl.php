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
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/uikit.almost-flat.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/addons/uikit.addons.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/addons/uikit.gradient.addons.min.css" rel="stylesheet" />
<!--UIKIT-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/stylesheets/screen.css" rel="stylesheet" />

<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/sites-responsive.css" rel="stylesheet" />

<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/layout.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/jquery.ui.timepicker.css" rel="stylesheet" />

<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/fancybox/source/jquery.fancybox.css" rel="stylesheet" />

<?php endif;?>

</head>

<?php if ( Yii::app()->functions->getOption("layout_themes") == 7):?>

<?php endif;?>

<?php 
$disabled_wishlist=Yii::app()->functions->getOption("disabled_wishlist");
$disabled_notes=Yii::app()->functions->getOption("disabled_notes");
$disabled_events=Yii::app()->functions->getOption("disabled_events");
$disabled_cashondelivery=Yii::app()->functions->getOption("disabled_cashondelivery");
$disabled_voucher=Yii::app()->functions->getOption("disabled_voucher");
$disabled_offlinepayment=Yii::app()->functions->getOption("disabled_offlinepayment");
$disabled_reservation=Yii::app()->functions->getOption("disabled_reservation");
?>




<div id="mobile_menu_wrap" class="hidden-lg hidden-md">
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
    
    <?php if ( Yii::app()->functions->getOption("allowed_ordering")==2 ):?>
    <?php else :?>
    <li>
    <a href="<?php echo Yii::app()->request->baseUrl;?>/store/recent-order" class="profile"><i class="glyphicon glyphicon-list-alt"></i> <?php echo Yii::t('default',"My Orders")?></a>
    </li>
    <?php endif;?>
    
    <?php if ( Yii::app()->functions->getOption("allowed_ordering")==2 ):?>
    <?php else :?>
      <?php if ( $disabled_wishlist==""):?>
      <li>    
      <a href="<?php echo Yii::app()->request->baseUrl;?>/store/wishlist"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo Yii::t('default',"WishList")?></a>   
      </li> 
      <?php endif;?>
    <?php endif;?>
    
    <?php if ( $disabled_events ==""):?>
    <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/events" ><i class="fa fa-calendar-o"></i> <?php echo Yii::t('default',"Events")?></a></li>
    <?php endif;?>
    
    <?php if ( $disabled_reservation ==""):?>
    <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/reservation"><i class="fa fa-calendar"></i> &nbsp;<?php echo Yii::t('default',"Reservation")?></a></li>   
    <?php endif;?>
        
    <?php if ( $pages=Yii::app()->functions->getPagesActive(100) ):?>
      <?php foreach ($pages as $val_pages):?>
      <li>
      <a href="<?php echo Yii::app()->request->baseUrl;?>/store/page/<?php echo $val_pages['friendly_url']?>">
      <?php if ( !empty($val_pages['page_icon'])):?>
      <i class="<?php echo $val_pages['page_icon']?>"></i>
      <?php endif;?>
          <?php echo ucwords( Yii::t("default",$val_pages['page_name']) )?>
      </a>
      </li>
      <?php endforeach;?>
    <?php endif;?>
                    
    <?php if (Yii::app()->functions->isUserLoggedIn()):?>
    <li>
    <a href="<?php echo Yii::app()->request->baseUrl;?>/store/profile" class="profile"><i class="glyphicon glyphicon-user"></i> <?php echo Yii::t('default',"Profile")?></a>
    </li>
         
    <li>
    <a href="<?php echo Yii::app()->request->baseUrl;?>/store/logout" class="logout"><i class="glyphicon glyphicon-log-out"></i> <?php echo Yii::t('default',"Logout")?></a>
    </li>    
    <?php else :?>            
    <li>
    <?php if ( Yii::app()->functions->getOption("allowed_ordering")==2 ):?>
    <?php else :?>
    <a href="javascript:;" data-toggle="modal" data-target=".pop_login"><i class="glyphicon glyphicon-log-in"></i> <?php echo Yii::t('default',"Login & Signup")?>
    </a>
    <?php endif;?>
    </li>     
    <?php endif;?>
    
        
       </ul>
    </div>
</div>

<header>
          <div class="wrap">
            <div class="row">
              <!--logo -->
              <div id="logo">
               <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/site-structure/logo.png">
              <a href="#mobile_menu_wrap" data-uk-offcanvas ><i class="fa fa-bars"></i></a>
              </div>

              <!-- logo ends -->
              <!-- right nav -->
              <div id="right-nav" class="hidden-xs">
                <!-- top nav -->
                <div class="top-nav">
                  <ul>
                      <li class="social-share">
                      <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-yelp"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                      </ul>
                    </li>
                    <li> Phone: (215) 662-0818</li>
                    <li><i class="fa fa-map-marker"></i> 60 S 38th St, Philadelphia, PA 19104</li>
                    <li><a href="javascript:;" data-toggle="modal" data-target=".pop_login"><i class="fa fa-sign-in"></i> <?php echo Yii::t('default',"Login & Signup")?></a>

                       <?php if (Yii::app()->functions->isUserLoggedIn()):?>      
      <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/logout" class="logout"><i class="fa fa-sign-out"></i> <?php echo Yii::t('default',"Logout")?></a></li>          
      
      <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/profile" class="profile"><i class="fa fa-user"></i> <?php echo Yii::t('default',"Profile")?></a></li>                        
      
      <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/recent-order"><i class="fa fa-list-alt"></i> <?php echo Yii::t('default',"My Orders")?></a>      
      </li>           
      
      <?php if ( $disabled_reservation==""):?>
      <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/reservation"><i class="fa fa-calendar"></i> &nbsp;<?php echo Yii::t('default',"Reservation")?></a></li>   
      <?php endif;?>
      
      <?php else :?>
      <?php if ( Yii::app()->functions->getOption("allowed_ordering")==2 ):?>
      <li><a href="javascript:;">&nbsp;</a></li>      
        <?php else :?>
                  
            
            <?php if ( $disabled_reservation==""):?>
             
            <?php endif;?>
            
            <?php endif;?>
      <?php endif;?>  
      
      
      <?php if ( $pages=Yii::app()->functions->getPagesActive(2) ):?>
        <?php foreach ($pages as $val_pages):?>
        <li>
        <a href="<?php echo Yii::app()->request->baseUrl;?>/store/page/<?php echo $val_pages['friendly_url']?>">
        <?php if ( !empty($val_pages['page_icon'])):?>
        <i class="<?php echo $val_pages['page_icon']?>"></i>
        <?php endif;?>
          <?php echo ucwords( Yii::t("default",$val_pages['page_name']) )?>
        </a>
        </li>
        <?php endforeach;?>
        <?php endif;?>



                    </li>
                  </ul>
                </div>
                <!-- top nav ends -->
                <div class="clear"></div>
                <!-- main navi -->
                <div class="main-navi">
                  <nav>
                    <ul>
                      <li>
        
    <div class="top_nav">
      <div class="<?php echo Yii::app()->functions->getOption("allowed_ordering")==2?"first_menub":"first_menu";?>">        
      <ul>
     
        
      
      </ul>
        <div class="clear"></div>       
      </div> <!--END first_menu-->
      
      <div class="second_menu">
        <ul>        
        
        <?php if ( $pages=Yii::app()->functions->getPagesActive() ):?>
        <?php foreach ($pages as $val_pages):?>

        <li>
        <a href="<?php echo Yii::app()->request->baseUrl;?>/store/page/<?php echo $val_pages['friendly_url']?>">
        <?php if ( !empty($val_pages['page_icon'])):?>
        <i class="<?php echo $val_pages['page_icon']?>"></i>
        <?php endif;?>
          <?php echo ucwords( Yii::t("default",$val_pages['page_name']) )?>
        </a>
        </li>
        <?php endforeach;?>
        <?php endif;?>
        
        <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/contact-us" class="contact"><i class="fa fa-envelope-o"></i> <?php echo Yii::t('default',"Contact")?></a></li>            
            <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/reservation"><i class="fa fa-calendar"></i> &nbsp;<?php echo Yii::t('default',"Reservation")?></a></li>     
        <?php if ( $disabled_events==""):?>
        <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/events" ><i class="fa fa-calendar-o"></i> <?php echo Yii::t('default',"Events")?></a></li>
        <?php endif;?>
        
        
        <?php if ( Yii::app()->functions->getOption("allowed_ordering")==2 ):?>
        
        <?php if ( $disabled_reservation==""):?>
        <li><a href="<?php echo Yii::app()->request->baseUrl;?>/store/reservation"><i class="fa fa-calendar"></i> &nbsp;<?php echo Yii::t('default',"Reservation")?></a></li>   
        <?php endif;?>
        
        <?php else :?>
          <?php if ( $disabled_wishlist==""):?>
          <li><a href="javascript:;" class="favorites"><i class="fa fa-plus-circle"></i> <?php echo Yii::t('default',"WishList")?></a>
          <?php endif;?>
        <?php endif;?>
        
        <div class="wish_list_wrap" style="display:none;"></div>
        </li>
        <li><a href="<?php echo Yii::app()->request->baseUrl."/store";?>"><i class="fa fa-home"></i> <?php echo Yii::t('default',"Home")?></a></li>
            <div class="clear"></div>
        </ul>
      </div> <!--END second_menu-->
      </div> <!--END right top_nav--></li>
                    </ul>
                  </nav>
                </div>
                <!-- main navi ends -->
              </div>
              <!--right nav ends -->

               <div class="right-cart">
          <?php 
          $allowed_ordering=Yii::app()->functions->getOption("allowed_ordering");         
          ?>
          <?php if ( $allowed_ordering == 2):?>
          <?php else :?>
        <a href="javascript:;" class="cart_handle">       
        <i class="fa fa-shopping-cart"></i> 
        <div class="cart">                    
          <span class="cart_item">0</span>            
        </div> <!--cart-->
        </a>
        <div class="cart_details_wrap">
            <div class="cart_details_wrap_inner">
            <ul>          
            </ul>     
                  
            <!--VOUCHER-->
            <?php if ( $disabled_voucher==""):?>
            <?php 
            $voucher_code=isset($_SESSION['temp_voucher_code'])?$_SESSION['temp_voucher_code']:"";
            ?>            
            <div class="discount_wrap apply_remove_voucher <?php echo empty($voucher_code)?"hide":"";?>">
             <a href="javascript:;" id="remove_discount" class="mybtn buttonorange">
              <?php echo Yii::t('default',"Remove Discount Code")?></a>
             </div>
            
            <div class="discount_wrap apply_voucher_code <?php echo !empty($voucher_code)?"hide":"";?>" >
             <input type="text" name="voucher_code" id="voucher_code" placeholder="Enter Discount Code" >
             <a href="javascript:;" id="apply_discount" class="mybtn buttonorange">
              <?php echo Yii::t('default',"Submit Discount Code")?></a>
            </div>           
            <?php endif;?>
            <!--VOUCHER-->
            
            <div class="cart_input_block">
              <a href="<?php echo Yii::app()->request->baseUrl;?>/store/cart" class="btn_grey"><?php echo Yii::t('default',"CART")?></a>
              <!--<a href="javascript:;" id="checkout" class="btn_grey"  data-toggle="modal" data-target=".checkout" >
              <?php echo Yii::t('default',"CHECKOUT")?></a>-->
              <a href="javascript:;" id="checkout" class="btn_grey">
              <?php echo Yii::t('default',"CHECKOUT")?></a>
            </div>               
            </div>
        </div> <!--cart_details_wrap-->
       <?php endif;?> 
    </div>


            </div>
          </div>
        </header>

    <div class="clear"></div>
  </div> <!--header-->
</div>

<div class="main_content">
 
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
          <h4 id="mySmallModalLabel" class="modal-title"> <?php echo yii::app()->functions->getOption('store_name'); ?></h4>
        </div>
        <div class="modal-body">
          <h3><?php echo Yii::t('default',"Delivery or Carryout")?>?</h3>
          
 <?php
$checkout_type1=Yii::app()->functions->getOption('checkout_type_1');
$checkout_type2=Yii::app()->functions->getOption('checkout_type_2');
$force_checkout=false;
if ( $checkout_type1 =="" && $checkout_type2==""){
  $force_checkout=true;
}
?>
          
<?php if ( $checkout_type1==1 || $force_checkout==true):?>
          <a class="btn_grey" href="<?php echo Yii::app()->request->baseUrl;?>/store/delivery"><?php echo Yii::t('default',"Delivery")?></a>
<?php endif;?>

<?php if ( $checkout_type2==2 || $force_checkout==true):?>

          <a class="btn_grey" href="<?php echo Yii::app()->request->baseUrl;?>/store/carryout"><?php echo Yii::t('default',"Carryout")?> </a>
<?php endif;?>
          
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
         
         <p style="margin-top:10px;">
         <a href="<?php echo Yii::app()->request->baseUrl;?>/store/forgotpassword"><?php echo t("Forgot Password")?>?</a>
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
<?php 
$is_paypal_enabled=Yii::app()->functions->getOption("paypal_enabled");
$disabled_cashondelivery=Yii::app()->functions->getOption("disabled_cashondelivery");
$disabled_offlinepayment=Yii::app()->functions->getOption("disabled_offlinepayment");
$braintree_enabled=Yii::app()->functions->getOption("braintree_enabled");
$admin_stripe_enabled=Yii::app()->functions->getOption("admin_stripe_enabled");  
 ?>
<!--<button class="btn btn-primary" data-toggle="modal" data-target=".pop_mode_of_payment">Small modal</button>-->
<div class="modal fade pop_mode_of_payment" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="mySmallModalLabel" class="modal-title"><?php echo Yii::t('default',"Method Of Payment")?></h4>
      </div>      
      <div class="modal-body">
      
       <?php if ( $disabled_cashondelivery==""):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/cashondeliver" id="mod_payment_cod" class="btn btn-success">
       <?php echo Yii::t('default',"Cash On delivery")?>
       </a>
       <?php endif;?>
       
       <?php if ($is_paypal_enabled==1):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/paypalinit" id="mod_payment_paypal" class="btn btn-info">
       <?php echo Yii::t('default',"Paypal")?></a>
       <?php endif;?>
       
       <?php if ($disabled_offlinepayment==""):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/offlinePayment" id="mod_payment_offline" class="btn btn-success">
       <?php echo Yii::t('default',"Card")?></a>
       <?php endif;?>
       
       <?php if ( $braintree_enabled==1):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/braintree" id="mod_payment_braintree" class="btn btn-success">
       <?php echo Yii::t('default',"Credit Card")?></a>
       <?php endif;?>
       
       <?php if ( $admin_stripe_enabled=="yes"):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/stripeinit/?trans_type=carryout" id="mod_payment_stripe" class="btn btn-success">
       <?php echo Yii::t('default',"Stripe")?></a>
       <?php endif;?>
       
    </div> <!-- END modal-body-->
    </div> <!--END MODAL CONTENT-->        
  </div>
</div>
<!--********************************************
   END MODE OF PAYMENT
********************************************-->

        <footer>
          <!-- footer top -->
          <div class="upper-footer">
            <div class="wrap">
              <div class="row">
                <div class="full-width">
                  <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/site-structure/footer-logo.png">
                      <?php if ( yii::app()->functions->getOption("footer_store_name") ):?>
                      <p><?php echo yii::app()->functions->getOption('footer_store_name')?>
                      <?php else :?>
                      <p><?php echo yii::app()->functions->getOption('store_name')?> &copy; 2014</p>   
                      <?php endif;?>

                        <?php 
       $store_address=Yii::app()->functions->getOption("address");
       $store_phone=Yii::app()->functions->getOption("phone_number");
       $store_email=Yii::app()->functions->getOption("contact_email");
       ?>

                  <ul class="address">
                    <li><?php if (!empty($store_address)){echo $store_address;}?></li>
                    <li> <?php if (!empty($store_phone)):?><i class="fa fa-phone"></i> <?php echo $store_phone?>
                    <?php endif;?>
                     </li>
                    <li>
                     <?php if (!empty($store_email)):?>
     <i class="fa fa-envelope-o"></i> <?php echo $store_email?>
     <?php endif;?>
                    </li>
                  </ul>

                  <h5>Opening & Closing hours</h5>
                  <ul class="address">
                    <li><?php 
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
   <div><i class="fa fa-home"></i>  <?php echo Yii::t("default","Store Hours Open");?>:</div>
   <?php if (is_array($stores_open_day) && count($stores_open_day)>=1):?>
   <?php foreach ($stores_open_day as $val_day):?>
   <li>
     
     <p class="day"><?php echo Yii::t("default",$val_day);?></p>
     <p>
     <?php 
     $has_time=false;
     if (array_key_exists($val_day,(array)$stores_open_am_start)){      
      if (!empty($stores_open_am_start[$val_day])){
         echo "( ".$stores_open_am_start[$val_day];
         echo " - ";
         $has_time=true;
      }
     }     
     if (array_key_exists($val_day,(array)$stores_open_am_end)){      
      if (!empty($stores_open_am_end[$val_day])){
         echo $stores_open_am_end[$val_day];
         echo " )";
      }
     }
     if (array_key_exists($val_day,(array)$stores_open_pm_start)){      
      if (!empty($stores_open_pm_start[$val_day])){
        echo " </br> ( ";
        echo $stores_open_pm_start[$val_day];       
        echo " - ";
        $has_time=true;
      }
     }
     if (array_key_exists($val_day,(array)$stores_open_pm_end)){      
      if (!empty($stores_open_pm_end[$val_day])){
         echo $stores_open_pm_end[$val_day];
         echo " )";
      }
     }
     if (array_key_exists($val_day,(array)$text_day)){      
      if (!empty($text_day[$val_day])){
        if ( $has_time ){
          echo " , ";
        }           
          echo $text_day[$val_day];       
      }
     }
     ?></li>
    
      <?php endforeach;?>
   <?php endif;?>
   <?php endif;?>
   </div>
   <!--END store_hours_wrap-->

                  </ul>


                </div>
              </div>
            </div>
          </div>
          <!-- footer top ends -->
          <!-- footer bottom -->
          <div class="bottom-footer">
          <div class="wrap">
          <div class="row">
            <!-- copyright -->
            <div class="copyright">© copyright 2015 sitarindiapa</div>
            <!-- copyright ends-->
            <!-- credit -->
            <div class="credit">Website Designed by  <a href="http://jerseyitech.com/">jerseyitech</a></div>
            <!-- credit ends --> 
          </div>
          </div>
          </div>
          <!-- footer bottom ends -->
        </footer>

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

<input type="hidden" name="allowed_ordering" id="allowed_ordering" value="<?php echo Yii::app()->functions->getOption("allowed_ordering");?>">
<?php echo CHtml::hiddenField('store_hours_format_value',Yii::app()->functions->getOption("store_hours_format"))?>
<?php echo CHtml::hiddenField('disabled_checkout',Yii::app()->functions->getOption("disabled_checkout"))?>

</body>

<?php if (!isset($_GET['noscript'])):?>

<?php 
$js_lang=Yii::app()->functions->jsLanguage();
$js_lang_validator=Yii::app()->functions->jsLanguageValidator();
?>

<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
var ajax_url='<?php echo Yii::app()->request->baseUrl;?>/store/ajax';
var sites_url='<?php echo Yii::app()->request->baseUrl;?>';
var js_lang=<?php echo json_encode($js_lang)?>;
var myLanguage=<?php echo json_encode($js_lang_validator)?>;
</script>

<?php if ( Yii::app()->functions->getOption("layout_themes") == 7):?>
<script type="text/javascript">
jQuery(document).ready(function() {
  $("body.layout_themes7.full_layout2 .header .main, body.layout_themes7 .sider_bar_wrap").css({"background":"<?php echo Yii::app()->functions->getOption("custom_colors")?>"});
});
</script>
<?php endif;?>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/JQV/form-validator/jquery.form-validator.min.js" type="text/javascript"></script>

<!--BXSLIDER-->
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/bxslider/jquery.bxslider.min.js" type="text/javascript"></script>
<!--BXSLIDER-->

<?php if (Yii::app()->controller->getAction()->getId()=="ContactUs"):?>
<!--Google Maps-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<!--END Google Maps-->
<?php endif;?>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.ui.timepicker.0.3.3.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/alert/jquery.alerts.js" type="text/javascript"></script>

<script src="https://js.braintreegateway.com/v2/braintree.js"></script>

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

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.printElement.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/image.preview.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/fancybox/source/jquery.fancybox.js"></script>

<?php endif;?>

<?php if (isset($_GET['msg'])):?>
<input type="hidden" id="msg_get" class="msg_get"  value="<?php echo $_GET['msg']?>" >
<?php endif;?>


</html>