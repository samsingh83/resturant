<div data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="login_option_wrap">
<form id="forms" class="forms"  method="POST">
<input type="hidden" name="action" value="resetPassword">
<?php echo CHtml::hiddenField('ref',isset($_GET['ref'])?$_GET['ref']:'')?>
<?php echo CHtml::hiddenField('token',isset($_GET['token'])?$_GET['token']:'')?>



<h2><?php echo t("Reset Password")?></h2>
<div class="spacer"></div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"New Password")?>*</span>
<input type="password"  name="new_pass" required="true" class="form-control" placeholder="<?php echo Yii::t('default',"New Password")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><?php echo Yii::t('default',"Confirm Password")?>*</span>
<input type="password"  name="confirm_pass" required="true" class="form-control" placeholder="<?php echo Yii::t('default',"Confirm Password")?>">
</div>

<div class="input-group left">
<input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>"  class="mybtn buttonorange">
</div>


</form>
</div> <!--END login_option_wrap-->
</div> <!--END UK-->