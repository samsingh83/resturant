<?php
$order_id=isset($_GET['order_id'])?$_GET['order_id']:'';
echo CHtml::hiddenField('pre_order_id',$order_id);
echo CHtml::hiddenField('pre_order_status',10);
?>
<div class="pre_order_wrap">   
 <?php if (is_numeric($order_id)):?>
  <h3 class="uk-text-danger">
   <i class="fa fa-truck"></i>
   <?php echo Yii::t("default","Please do not refresh the page and wait for the response of the restaurant owner")?>
  </h3>
  <div class="pre-order-response">
    <p><?php echo Yii::t("default","Getting Response in")?> <span class="timer"></span></p>
    <i class="fa fa-spinner fa-spin preorder-loader"></i>
  </div>
  
  <div class="continue-pre-order">
  <?php if (isset($_GET['pmode'])):?>
  <a href="<?php echo Yii::app()->request->baseUrl."/store/paypal-verify?token=".$_GET['token']."&PayerID=".$_GET['PayerID'];?>" class="uk-button uk-button-success"><?php echo Yii::t("default","Click here Continue")?></a>
  <?php else :?>
  <a href="<?php echo Yii::app()->request->baseUrl."/store/receipt/order_id/".$order_id;?>" class="uk-button uk-button-success"><?php echo Yii::t("default","Click here Continue")?></a>
  <?php endif;?>
  </div>
 <?php else :?>
   <p class="uk-text-danger"><?php echo Yii::t("default","Opps Sorry but we cannot find what you are looking for")?></p>
 <?php endif;?>
</div>