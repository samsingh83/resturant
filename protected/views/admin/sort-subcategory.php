<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategory" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>
<div style="height:20px;"></div>


<p><?php echo Yii::t('default',"Drag the image to sort")?> </p>
<?php if ($data=yii::app()->functions->getSubcategory()):?>
  <ul class="sortable" data-id="sort_category" data="subcategory" data-key="subcat_id">
  <?php foreach ($data as $val): ?> 
   <li class="<?php echo $val['subcat_id']?>">           
      <p><?php echo $val['subcategory_name']?></p>     
   </li>
  <?php endforeach;?>
  <div class="clear"></div>
  </ul>
<?php else :?>
<p><?php echo Yii::t('default',"No Item found")?>.</p>
<?php endif;?>
