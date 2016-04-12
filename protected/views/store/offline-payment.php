

<div class="offline_wrap">

<form id="frm_offline_payment" class="uk-form frm_offline_payment uk-panel uk-panel-box" onsubmit="return false;">
<input type="hidden" name="action"  id="action" value="addPayment">
<?php echo CHtml::hiddenField('trans_type',$_GET['trans_type']);?>
<h3 class="uk-h3"><?php echo Yii::t("default","Select Card")?></h3>

<div class="uk-form-row">    
    <div class="uk-form-controls">
        <?php echo CHtml::dropDownList('cc_id','',array(),
        array('class'=>"uk-width-1-1",'data-validation'=>"required")
        )?>
    </div>
</div>

<div class="uk-form-row">  
  <input  type="submit" value="<?php echo Yii::t("default","Submit Order")?>" class="uk-button uk-button-success place_order">
  <a href="javascript:;" class="uk-button add_cc"><?php echo Yii::t("default","Add new card")?></a>
</div>

</form>

<div class="spacer"></div>

<form id="frm_add_card" class="uk-form uk-form-horizontal frm_add_card uk-panel uk-panel-box" onsubmit="return false;">
<input type="hidden" name="action" id="action" value="addCreditCard">

<!--<h3 class="uk-h3"><?php echo Yii::t("default","Add new card")?></h3>-->

<div class="uk-form-row">
    <label class="uk-form-label"><?php echo Yii::t("default","Card Name")?></label>
    <div class="uk-form-controls">
        <?php echo CHtml::textField('card_name','',array('class'=>"uk-width-1-1",'data-validation'=>"required"))?>
    </div>
</div>

<div class="uk-form-row">
    <label class="uk-form-label"><?php echo Yii::t("default","Credit card number")?></label>
    <div class="uk-form-controls">
        <?php echo CHtml::textField('credit_card_number','',array('class'=>"numeric_only uk-width-1-1",'data-validation'=>"required"))?>
    </div>
</div>

<div class="uk-form-row">
    <label class="uk-form-label"><?php echo Yii::t("default","Exp. month")?></label>
    <div class="uk-form-controls">
        <?php echo CHtml::dropDownList('expiration_month','',
        Yii::app()->functions->ccExpirationMonth()
        ,array('class'=>"uk-width-1-1",
        'data-validation'=>"required"
        ))?>
    </div>
</div>


<div class="uk-form-row">
    <label class="uk-form-label"><?php echo Yii::t("default","Exp. year")?></label>
    <div class="uk-form-controls">
        <?php echo CHtml::dropDownList('expiration_yr','',
        Yii::app()->functions->ccExpirationYear()
        ,array('class'=>"uk-width-1-1",'data-validation'=>"required"))?>
    </div>
</div>

<div class="uk-form-row">
    <label class="uk-form-label">CVV</label>
    <div class="uk-form-controls">
        <?php echo CHtml::textField('cvv','',array('class'=>"numeric_only uk-width-1-1",'data-validation'=>"required",
        'maxlength'=>4))?>
    </div>
</div>

<div class="uk-form-row">
    <label class="uk-form-label"><?php echo Yii::t("default","Billing Address")?></label>
    <div class="uk-form-controls">
        <?php //echo CHtml::textField('billing_address','',array('class'=>"uk-width-1-1",'data-validation'=>"required"))?>
        <?php echo CHtml::textArea('billing_address','',array(
          'class'=>"uk-width-1-1",
          'data-validation'=>"required"
        ))?>
    </div>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"></label>
  <input  type="submit" value="<?php echo Yii::t("default","Add Card")?>" class="uk-button ">
</div>

</form>
</div>