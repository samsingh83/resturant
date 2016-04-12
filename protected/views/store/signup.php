<div data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="login_option_wrap">
<form id="frm_signup" class="form"  method="POST">
<input type="hidden" name="action" value="signUp">
<input type="hidden" name="trans_type" id="trans_type" value="signUp">
<input type="hidden" name="referer" id="referer" value="<?php echo isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"";?>">
<h2><?php echo t("Signup")?></h2>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Name")?>*</span>
<input type="text"  name="fullname" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Name")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Phone")?></span>
<input type="text"  name="phone" class="form-control" placeholder="<?php echo Yii::t('default',"Phone number")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Phone/ Mobile")?></span>
<input type="text"  name="mobile" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Phone/ Mobile")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Email")?>*</span>
<input type="text"  name="email" data-validation="email" class="form-control" placeholder="<?php echo Yii::t('default',"Email Address")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Password")?>*</span>
<input type="password" name="password" data-validation="required" class="form-control" placeholder="<?php echo Yii::t('default',"Password")?>">
</div>

<div class="input-group left">
<input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>"  class="mybtn buttonorange">
</div>

<div class="social_login_wrap left">
<?php if (yii::app()->functions->getOption('fb_flag')==1):?>
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"><?php echo Yii::t('default',"Sign in with Facebook")?></fb:login-button>	       
<i style="display:none;" class="login_loading_indicator fa fa-spinner fa-spin"></i>
<?php endif;?>
</div>

<div class="left" style="margin-left:15px;margin-top:10px;">
 <a href="<?php echo Yii::app()->request->baseUrl;?>/store/forgotpassword"><?php echo t("Forgot Password")?>?</a>
</div>

<div class="clear"></div>

</form>
</div> <!--END login_option_wrap-->
</div> <!--END UK-->