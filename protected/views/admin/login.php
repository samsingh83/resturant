<?php 
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_GET['logout'])){	
    session_destroy();
    Yii::app()->request->cookies['rst_user'] = new CHttpCookie('rst_user', "");    		    
}

$store_name=Yii::app()->functions->getOption("store_name");
?>

<div class="uk-panel uk-panel-box uk-width-medium-1-3">	
  
    <h3 class="uk-h3"><?php echo $store_name;?> <?php echo t("Back Office")?></h3>
  
	<form id="frm_login" method="POST" class="uk-form">
	
	<input type="hidden" name="action" value="login">
		
	<div class="uk-form-row">
      <div class="uk-form-icon uk-width-1">
        <i class="uk-icon-user"></i>         
         <?php 
         echo CHtml::textField('username','',array(
           'class'=>'uk-width-1',
           'required'=>'required',
           'placeholder'=>t("Username")
         ));
         ?>
         
      </div>
    </div>
    
    <div class="uk-form-row">
      <div class="uk-form-icon uk-width-1">
        <i class="uk-icon-lock"></i>         
         <?php 
         echo CHtml::passwordField('password','',array(
           'class'=>'uk-width-1',
           'required'=>'required',
           'placeholder'=>t("Password")
         ));
         ?>
         
      </div>
    </div>
    
    <div class="uk-form-row">
    <button id="login-btn" type="submit" class="uk-button uk-width-1">
     <?php echo t("Signin")?> <i class="uk-icon-chevron-circle-right"></i>
    </button>
    </div>
       	
	</form>
</div>
