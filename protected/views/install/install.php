<?php if (!Yii::app()->functions->isAlreadyInstall()):?>

<form id="frm_install" method="POST" onsubmit="return false;">
<input type="hidden" name="action" value="install">

<h3><?php echo Yii::t('default',"Store Information")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Store Name")?></label>
<?php echo CHtml::textField('store_name','',array('data-validation'=>'required'))?>
</div>

<h3><?php echo Yii::t('default',"Store Currency")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Currency Code")?></label>
<?php echo CHtml::dropDownList('currency_code','USD',
(array)Yii::app()->functions->currencyListRaw(),array('data-validation'=>'required')
)?>
</div>

<h3><?php echo Yii::t('default',"Store Information")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Address")?></label>
<?php echo CHtml::textField('address','',array('data-validation'=>'required') )?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Contact Phone Number")?></label>
<?php echo CHtml::textField('phone_number','',array('data-validation'=>'required'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Contact Email")?></label>
<?php echo CHtml::textField('contact_email','',array('data-validation'=>'required'))?>
</div>

<h3><?php echo Yii::t('default',"Admin User")?></h3>

<div class="input_block">
 <label><?php echo Yii::t('default',"Username")?> :</label>
 <input type="text" name="username" data-validation="required" value="" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Password")?> :</label>
 <input type="password" name="password" data-validation="required" value="" >
</div>

<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" >

</form>

<?php else :?>
<div class="error"><?php echo Yii::t('default',"It Seems that the application already installed")?>.</div>
<p>Click <a href="<?php echo Yii::app()->request->baseUrl."/admin";?>"><?php echo Yii::t('default',"here")?></a> <?php echo Yii::t('default',"to login")?></p>
<?php endif;?>