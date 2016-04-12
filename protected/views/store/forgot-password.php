<div data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="login_option_wrap">
<form id="forms" class="forms"  method="POST">
<input type="hidden" name="action" value="forgotPassword">


<h2><?php echo t("Forgot Password")?></h2>
<div class="spacer"></div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Email Address")?>*</span>
<input type="text"  name="email_address" required="true" class="form-control" placeholder="<?php echo Yii::t('default',"Name")?>">
</div>

<div class="input-group left">
<input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>"  class="mybtn buttonorange">
</div>


</form>
</div> <!--END login_option_wrap-->
</div> <!--END UK-->