<form id="frm_item" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="action" value="setDefaultOrderStatus">

<h3><?php echo Yii::t("default","Set Default Order Status:")?></h3>

<div class="input_block">
<label><?php echo Yii::t('default',"Default Status")?></label>
<?php if ($order_stats=Yii::app()->functions->orderStatusList()):?>
<?php echo CHtml::dropDownList('stats_id',yii::app()->functions->getOption('stats_id'),$order_stats)?>
<?php endif;?>
</div>

<p><?php echo Yii::t("default","The default order status when the client place order on front end.")?></p>

<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >


<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/order-stats-settings" class="uk-button">
<?php echo Yii::t('default',"Back")?>
</a>

</form>