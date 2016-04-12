<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/multioptions" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>
<div style="height:20px;"></div>

<p><?php echo Yii::t('default',"Drag the image to sort")?> </p>
<?php if ($data=yii::app()->functions->getMultiOptionList()):?>
  <ul class="sortable" data-id="sort_category" data="multi_options" data-key="multi_id">
  <?php foreach ($data as $val): ?> 
   <li class="<?php echo $val['multi_id']?>">     
      <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">
      <p><?php echo $val['multi_name']?></p>     
   </li>
  <?php endforeach;?>
  <div class="clear"></div>
  </ul>
<?php else :?>
<p><?php echo Yii::t('default',"No Item found")?>.</p>
<?php endif;?>
