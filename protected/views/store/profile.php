<?php yii::app()->functions->sessionInit();?> 

<?php if (Yii::app()->functions->isUserLoggedIn()):?>    
<?php 
$data=Yii::app()->functions->getClientInfo( Yii::app()->functions->userId() );
$data=$data[0];
?>
<div data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<form id="frm_profile" class="uk-form uk-form-stacked forms" onsubmit="return false;">

<input type="hidden" name="action" value="updateProfile">

<h2><?php echo Yii::t("default","User Profile")?></h2>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-user"></i> <?php echo Yii::t("default","Name")?>*</span>
<input type="text" value="<?php echo $data['fullname']?>"  name="fullname" data-validation="required" class="form-control" placeholder="<?php echo Yii::t("default","Name")?>">
</div>

<!--<div class="input-group">
<span class="input-group-addon"><i class="fa fa-phone"></i> <?php echo Yii::t("default","Phone")?>*</span>
<input type="text" value="<?php echo $data['phone']?>" name="phone" class="form-control" placeholder="<?php echo Yii::t("default","Phone")?>">
</div>-->

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-mobile"></i> <?php echo Yii::t("default","Phone/ Mobile")?>*</span>
<input type="text"  value="<?php echo $data['mobile']?>" name="mobile" data-validation="required" class="form-control" placeholder="<?php echo Yii::t("default","Mobile")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-envelope-o"></i> <?php echo Yii::t("default","Email")?>*</span>
<input type="text"  value="<?php echo $data['email']?>" name="email" data-validation="required" class="form-control" placeholder="<?php echo Yii::t("default","Email")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-truck"></i> <?php echo Yii::t("default","Delivery address")?>*</span>
<input type="text" value="<?php echo $data['delivery_address']?>"  name="delivery_address" data-validation="required" class="form-control" placeholder="<?php echo Yii::t("default","Delivery address")?>">
</div>


<h2>Change Password</h2>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-unlock-alt"></i> <?php echo Yii::t("default","Old Password")?></span>
<input type="password"  name="old_password"  class="form-control" placeholder="<?php echo Yii::t("default","Old Password")?>">
</div>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-unlock-alt"></i> <?php echo Yii::t("default","New Password")?></span>
<input type="password"  name="new_password"  class="form-control" placeholder="<?php echo Yii::t("default","New Password")?>">
</div>

<div class="btn-group">
<button type="submit" class="btn_submit btn btn-success"><i class="fa fa-check-square-o"></i> <?php echo Yii::t("default","Update")?> </button>
<i  class="process_indicator fa fa-spinner fa-spin" style="display:none;"></i>
</div>
</form>
<?php else :?>
<p><?php echo Yii::t("default","Not login")?></p>
<?php endif;?>
</div> <!--END UK-->