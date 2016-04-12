<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/cooking-ref" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>
<div style="height:20px;"></div>

<p><?php echo Yii::t('default',"Drag the image to sort")?> </p>
<?php if ($data=yii::app()->functions->getCookingref()):?>
  <ul class="sortable" data-id="sort_category" data="cooking_ref" data-key="cook_id">
  <?php foreach ($data as $val): ?> 
   <li class="<?php echo $val['cook_id']?>">        
      <p><?php echo $val['cooking_name']?></p>     
   </li>
  <?php endforeach;?>
  <div class="clear"></div>
  </ul>
<?php else :?>
<p><?php echo Yii::t('default',"No Item found")?>.</p>
<?php endif;?>