<?php
$chk=yii::app()->functions->getOption('featured_on');
?>

<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/item" class="uk-button">
<i class="fa fa-list"></i> <?php echo Yii::t("default","List")?>
</a>

<div class="spacer"></div>

<form id="frm_featured_item" method="POST" >
<input type="hidden" name="action" value="featuredSettings">
<div class="input_block">
<label><?php echo Yii::t('default',"Show Featured products On Front Page?")?></label>
<?php echo CHtml::checkBox("is_featured",$chk,array('value'=>1))?>
</div>
</form>

<h4><?php echo Yii::t('default',"Drag the item to Featured products list")?></h4>
<div class="dragable_wrap left">
<p><?php echo Yii::t('default',"Drag the image to sort")?> </p>
<?php if ($data=yii::app()->functions->getFeatured()):?>
  <ul class="dragable" data-id="sort_category" data="item" data-key="item_id">
  <?php foreach ($data as $val): ?> 
   <li rel="<?php echo $val['item_id']?>">     
      <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">
      <p><?php echo $val['item_name']?></p>     
   </li>
  <?php endforeach;?>  
  <div class="clear"></div>
  </ul>
  <div class="clear"></div>
<?php else :?>
<ul class="dragable" data-id="sort_category" data="item" data-key="item_id">
</ul>
<?php endif;?>
</div>

<div class="featured_wrap right">
 <p><?php echo Yii::t('default',"Featured products List")?></p>
 <div class="featured_list"> 
 <?php if ($data=yii::app()->functions->getFeatured(1)):?>
  <ul class="featured-item">
 <?php foreach ($data as $val): ?> 
    <li rel="<?php echo $val['item_id']?>">
    <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">
    <p><?php echo $val['item_name']?></p>     
    </li>
 <?php endforeach;?>
 <div class="clear"></div>
 </ul>
 <?php endif;?>
 </div>
</div>
<div class="clear"></div>