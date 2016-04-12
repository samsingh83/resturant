<?php if (!isset($_SESSION)) { session_start();} ?>
<div class="uk-grid" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="recent_order_wrap_page left">
 <div class="cart_page">    
    <ul></ul>	
<div class="cart_input_block">
<!--<a href="javascript:;" id="checkout" class="btn_grey"  data-toggle="modal" data-target=".checkout" >
<?php echo Yii::t('default',"CHECKOUT")?></a>-->
<a href="javascript:;" id="checkout" class="btn_grey"><?php echo Yii::t('default',"CHECKOUT")?></a>

</div>	
 </div>
</div> <!--END recent_order_wrap-->

<div class="siderbar_wrap right">
 <?php Yii::app()->functions->categoryMenu()?>
</div> <!--END siderbar_wrap-->
<div class="clear"></div>
</div>