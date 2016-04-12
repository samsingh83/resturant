<?php
$sms_gateway_id='';$sender_id='';$api_username='';$api_password='';

if ( $sms=Yii::app()->functions->getOption("sms_gateway")){	
	$sms=json_decode($sms);	
	$sms_gateway_id=$sms->sms_gateway_id;
	$sender_id=$sms->sender_id;
	$api_username=$sms->api_username;
	$api_password=$sms->api_password;
}
?>
<form id="frm_sms" method="POST" onsubmit="return false;" class="uk-form uk-form-horizontal">
<input type="hidden" name="action" value="smsSettings">
<h2><?php echo Yii::t("default","Select Your SMS Gateway")?></h2>
<ul>
<li>
<img src="<?php echo Yii::app()->request->baseUrl;?>/assets/images/twilio.png" alt="" title="">
<input <?php echo $sms_gateway_id=="twilio"?"checked":"";?>   type="radio" name="sms_gateway_id" value="twilio" id="sms_gateway_id" class="sms_gateway_id"></li>
<li>
<img src="<?php echo Yii::app()->request->baseUrl;?>/assets/images/smsgloballogo.jpg" alt="" title="">
<input <?php echo $sms_gateway_id=="sms_global"?"checked":"";?> type="radio" name="sms_gateway_id" value="sms_global" id="sms_gateway_id" class="sms_gateway_id">
</li>
<div class="clear"></div>
</ul>

<div style="height:20px;"></div>

<div class="form_sms_results">
</div>


<div style="height:20px;"></div>

<div class="input_block">
<label><?php echo Yii::t("default","Notify Mobile Number")?></label>
<?php echo CHtml::textField('notify_mobile',Yii::app()->functions->getOption("notify_mobile"),array(
'placeholder'=>'') )?>
<span><?php echo Yii::t("default","Mobile number that will receive notification when there is a new order. multiple numbers must be separated by comma")?>.</span>
<span><?php echo Yii::t("default","Leave empty if you don't want to receive notification")?>.</span>
<span><?php echo Yii::t("default","Mobile number include country prefix eg. +1")?></span>
</div>

<div class="input_block">
<label><?php echo Yii::t("default","SMS Notification")?></label>
<?php echo CHtml::textArea('sms_notification_msg',Yii::app()->functions->getOption("sms_notification_msg"),
array(
  'style'=>'height:150px',
  'onkeyup'=>'return getChar(event);',
  'onkeydown'=>'return getCharDown(event);'
) )?>
<span> 	<?php echo Yii::t("default","SMS character remaining")?> : <em class="sms_rem">0</em></span>
<span>Available Tags {customer-name} = client name</span>
</div>

<div class="input_block">
<input type="submit" value="<?php echo Yii::t("default","Submit")?>" class="uk-button uk-button-success">
<a href="javascript:;" class="send_sms_test uk-button"><?php echo Yii::t("default","Send SMS Test")?></a>
</div>


</form>



<!--********************************************
   SEND EMAIL TEST
********************************************-->
<div class="modal fade sms_test_pop" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
         <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="mySmallModalLabel" class="modal-title"> <?php echo Yii::t("default","Send Email Test")?></h4>
        </div>
        <div class="modal-body">
                
        <form method="POST" onsubmit="return false;" id="frm_sms_test">       
        <input type="hidden" name="action" value="sendSMSTest">        
        <div class="input-group">
		<span class="input-group-addon"><?php echo Yii::t('default',"Mobile Number")?></span>
		<?php echo CHtml::textField('mobile_number_test','',array('placeholder'=>"",'data-validation'=>"required"))?>
        </div>
        
        <div class="input-group" style="margin-top:8px;">
        <input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
        </div>
        </form>
        
        </div> <!--modal-body-->
    </div>
  </div>
</div>
<!--********************************************
   END SEND EMAIL TEST
********************************************-->