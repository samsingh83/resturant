<div class="home_page">

<?php
$layout_menu=Yii::app()->functions->getOption("layout_menu");
dump($layout_menu);
?>

<?php if ( $layout_menu==1 || $layout_menu==""):?>
<div class="uk-grid" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="menu_gallery">	         
<?php if ($food_cat=yii::app()->functions->getCategory()): ?>
     <ul class="da-thumbs" id="da-thumbs">
      <?php foreach ($food_cat as $val): //dump($val);?>
      <li>      
	      <a href="<?php echo Yii::app()->request->baseUrl."/store/food-item/cat-id/".$val['cat_id']?>">	      
	        <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">
	        <div class="menu_overlay">
             <h5><?php echo $val['category_name']?></h5>
            </div>	      
            <!--<div class="food_wrap_inner">
	        <h2><?php echo $val['category_name']?></h2>
	        </div>-->
	      </a>
      </li>
      <?php endforeach;?>
     </ul>
     <div class="clear"></div>
<?php endif;?>
</div> <!--END mediakal_gallery-->
</div> <!--END uk-grid-->
<?php endif;?>


<?php
$add_text=Yii::app()->functions->getOption("add_text");
if ( !empty($add_text)){
	$add_text=json_decode($add_text);
}
?>
<?php if (is_array($add_text) && count($add_text)>=1):?>
<div class="promotional_wrap">
<?php foreach ($add_text as $val_text):?>
<?php 
$text_exp=explode(",",$val_text);
if (count($text_exp)==1){
	?>
	<img src="<?php echo Yii::app()->request->baseUrl."/upload/".$text_exp[0]?>" alt="" title="">
	<?php
} else {
	?>	
	<div class="promo_text" style="<?php echo Yii::app()->functions->formatAsCSS($text_exp)?>"><?php echo $text_exp[0]?></div>
	<?php
}
?>
<?php endforeach;?>
</div>
<?php endif;?>


<?php if (yii::app()->functions->getOption('featured_on')==1):?>
<?php if ($featured=Yii::app()->functions->featuredFoodItem()):?>
<div class="uk-grid" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="featured_item item_same_cat_wrap">
  <h4><span class="glyphicon glyphicon-th-list"></span> <?php echo Yii::t('default',"Featured products")?></h4>  
  <ul class="bx_slider_featured">
  <?php foreach ($featured as $val_f):?>
  <li>
<a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/item-id/".$val_f['item_id']?>">
       <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val_f['photo']?>" alt="<?php echo $val_f['item_name']?>" title="<?php echo ucwords($val_f['item_name'])?>">
       </a>
  </li>
  <?php endforeach;?>
  </ul>
</div> <!--END featured_item-->
</div> <!--END uk-grid-->
<?php endif;?> 
<?php endif;?> 

</div><!-- END home_page-->