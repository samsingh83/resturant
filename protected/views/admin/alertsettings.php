<?php 
$alert_sounds=Yii::app()->functions->getOption("alert_sounds");
$alert_notification=Yii::app()->functions->getOption("alert_notification");
?>

<form id="frm_alert_settings" method="POST" onsubmit="return false;" class="uk-form uk-form-horizontal">
<input type="hidden" name="action" value="alertSettings">

<h2><?php echo Yii::t("default","Enabled Alert Settings")?></h2>

<p><?php echo Yii::t("default","Enabled Alert Notification")?>.</p>
<div class="input_block">
<ul>
<li><input class="icheck" <?php echo $alert_notification==1?"checked":"";?> name="alert_notification" type="radio" value="1"> <?php echo Yii::t("default","Yes")?></li>
<li><input class="icheck" <?php echo $alert_notification==2?"checked":"";?> name="alert_notification" type="radio" value="2"> <?php echo Yii::t("default","No")?></li>
</ul>

<p><?php echo Yii::t("default","play alert sounds when there is new order.")?></p>
<div class="input_block">
<ul>
<li><input class="icheck" <?php echo $alert_sounds==1?"checked":"";?> name="alert_sounds" type="radio" value="1"> <?php echo Yii::t("default","Yes")?></li>
<li><input class="icheck" <?php echo $alert_sounds==2?"checked":"";?> name="alert_sounds" type="radio" value="2"> <?php echo Yii::t("default","No")?></li>
</ul>
</div>


<div >
<input type="submit" value="<?php echo Yii::t("default","Submit")?>" class="uk-button uk-button-success">
</div>

</form>