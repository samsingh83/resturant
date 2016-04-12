<?php if (!isset($_SESSION)) { session_start();} ?>
<div class="uk-grid" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="recent_order_wrap_page left">
<div class="recent_order_inner">
  <?php if (Yii::app()->functions->isUserLoggedIn()):?>
  <?php Yii::app()->functions->recentOrderWidget()?>
  <?php else :?>
  <p class="uk-alert">Please login <a data-target=".pop_login" data-toggle="modal" href="javascript:;"><?php echo Yii::t('default',"here")?></a></p>
  <?php endif;?>
</div>
</div> <!--END recent_order_wrap-->

<div class="siderbar_wrap right">
 <?php Yii::app()->functions->categoryMenu()?>
</div> <!--END siderbar_wrap-->
<div class="clear"></div>
</div>