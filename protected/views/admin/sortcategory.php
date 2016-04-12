<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/category" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?></a>
<div style="height:20px;"></div>

<p><?php echo Yii::t('default',"Drag the image to sort the category")?></p>
<?php if ($category=yii::app()->functions->getCategory()):?>
  <ul class="sortable" data-id="sort_category" data="category" data-key="cat_id">
  <?php foreach ($category as $val): ?> 
   <li class="<?php echo $val['cat_id']?>">     
      <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">
      <p><?php echo $val['category_name']?></p>     
   </li>
  <?php endforeach;?>
  <div class="clear"></div>
  </ul>
<?php else :?>
<p><?php echo Yii::t('default',"No Category found")?>.</p>
<?php endif;?>