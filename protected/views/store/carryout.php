<?php yii::app()->functions->sessionInit(); //unset($_SESSION[KARENDERIA]['login'])?> 

<?php //if (!isset($_SESSION[KARENDERIA]['login']) && $_SESSION[KARENDERIA]['login']!=1 ):?>
<?php if (!isset($_SESSION[KARENDERIA]['login'])):?>
<div class="login_option_wrap">
  <p><?php echo Yii::t('default',"Already have account?")?> <?php echo Yii::t("default","Click")?> <a href="javascript:;"  data-toggle="modal" data-target=".pop_login" ><?php echo Yii::t("default","here")?></a> <?php echo Yii::t('default',"to sign In")?> </p>
</div> <!--END login_option_wrap-->
<?php endif;?>

<?php $paypal_enabled=yii::app()->functions->getOption('paypal_enabled');?>

<form id="frm_delivery" class="form"  method="GET">

<?php //if (!isset($_SESSION[KARENDERIA]['login']) && $_SESSION[KARENDERIA]['login']!=1 ):?>
<?php if (!isset($_SESSION[KARENDERIA]['login']) ):?>
<input type="hidden" name="action" value="formDelivery">
<input type="hidden" name="trans_type" id="trans_type" value="carryout">
<input type="hidden" id="payment_enabled" name="payment_enabled" value="<?php echo $paypal_enabled?>">
<h2>Information</h2>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-user"></i> <?php echo Yii::t('default',"Name")?>*</span>
<input type="text"  name="fullname" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Name")?>">
</div>

<!--<div class="input-group">
<span class="input-group-addon"><i class="fa fa-phone"></i> <?php echo Yii::t('default',"Phone")?></span>
<input type="text"  name="phone" class="form-control" placeholder="<?php echo Yii::t('default',"Phone number")?>">
</div>-->

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-mobile"></i> <?php echo Yii::t('default',"Phone/ Mobile")?></span>
<input type="text"  name="mobile" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Mobile number")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-envelope-o"></i> <?php echo Yii::t('default',"Email")?>*</span>
<input type="text"  name="email" data-validation="email" class="form-control" placeholder="<?php echo Yii::t('default',"Email Address")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-unlock-alt"></i> <?php echo Yii::t('default',"Password")?>*</span>
<input type="password" name="password" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Password")?>">
</div>


<div class="input-group left">
<input type="button" onclick="window.history.back();" class="btn_grey mybtn" value="<?php echo Yii::t('default',"Back")?>"></input>
<input type="submit" id="submit" value="<?php echo Yii::t('default',"Next")?>"  class="mybtn buttonorange">
</div>

<div class="social_login_wrap left">
<?php if (yii::app()->functions->getOption('fb_flag')==1):?>
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"><?php echo Yii::t('default',"Sign in with Facebook")?></fb:login-button>	       
<i style="display:none;" class="login_loading_indicator fa fa-spinner fa-spin"></i>
<?php endif;?>
</div>
<div class="clear"></div>

<?php else :?>
  <?php   
  $is_paypal_enabled=Yii::app()->functions->getOption("paypal_enabled");  
  $disabled_cashondelivery=Yii::app()->functions->getOption("disabled_cashondelivery");
  $disabled_offlinepayment=Yii::app()->functions->getOption("disabled_offlinepayment");
  $braintree_enabled=Yii::app()->functions->getOption("braintree_enabled");  
  $admin_stripe_enabled=Yii::app()->functions->getOption("admin_stripe_enabled");    
  ?>
  <div class="" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
          <h4 id="mySmallModalLabel" class="modal-title"><?php echo Yii::t('default',"Method Of Payment")?></h4>
      </div>      
      <div class="modal-body">
       <?php if ( $disabled_cashondelivery==""):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/cashondeliver/?trans_type=carryout" id="mod_payment_cod" class="btn btn-success">
       <?php echo Yii::t('default',"Cash On delivery")?></a>
       <?php endif;?>
       
       <?php if ($is_paypal_enabled==1):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/paypalinit/?trans_type=carryout" id="mod_payment_paypal" class="btn btn-info">
       <?php echo Yii::t('default',"Paypal")?></a>
       <?php endif; ?>
       
       <?php if ($disabled_offlinepayment=="" ):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/offlinePayment/?trans_type=carryout" id="mod_payment_offline" class="btn btn-success">
       <?php echo Yii::t('default',"Card")?></a>
       <?php endif;?>
       
       <?php if ( $braintree_enabled==1):?>
       <a href="<?php echo Yii::app()->request->baseUrl;?>/store/braintree/?trans_type=carryout" id="mod_payment_braintree" class="btn btn-success">
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
<?php endif;?>

</form>