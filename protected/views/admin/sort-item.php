


<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/item" class="uk-button">
<i class="fa fa-list"></i> <?php echo Yii::t("default","List")?>
</a>


<div style="height:20px;"></div>

<p><?php echo Yii::t('default',"Drag the image to sort")?> </p>
<?php if ($data=yii::app()->functions->getFoodItemList()):?>
  <ul class="sortable" data-id="sort_category" data="item" data-key="item_id">
  <?php foreach ($data as $val): ?> 
   <li class="<?php echo $val['item_id']?>">     
      <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">
      <p><?php echo $val['item_name']?></p>     
   </li>
  <?php endforeach;?>
  <div class="clear"></div>
  </ul>
<?php else :?>
<p><?php echo Yii::t('default',"No Item found")?>.</p>
<?php endif;?>
