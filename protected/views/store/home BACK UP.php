<div class="home_page">


<!--********************************
            ADD TEXT  & IMAGES
********************************-->
<?php $promo_text_postion=Yii::app()->functions->getOption("promo_text_postion");?>
<?php if ( $promo_text_postion ==1):?>
<?php
$add_text=Yii::app()->functions->getOption("add_text");
if ( !empty($add_text)){
	$add_text=json_decode($add_text);
}
?>
<?php if (is_array($add_text) && count($add_text)>=1):?>
<div class="promotional_wrap" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}" >
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
<?php endif;?>
<!--********************************
            END TEXT  & IMAGES
********************************-->


<?php $layout_menu=Yii::app()->functions->getOption("layout_menu");?>
<?php $pre_collapse=Yii::app()->functions->getOption("pre_collapse");?>
<?php 
if ( $layout_menu==7||$layout_menu==8||$layout_menu==9||$layout_menu==3||$layout_menu==5){	
} else $pre_collapse=2;
?>
<input type="hidden" name="pre_collapse" id="pre_collapse" value="<?php echo $pre_collapse;?>">


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

<?php else :?>


<?php if ( $layout_menu==9):?>
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


<?php if ( $layout_menu==6):?>
<?php $x=1;?>
<ul id="menu_tab" class="nav nav-tabs">
  <?php if ($food_cat=yii::app()->functions->getCategory()): ?>
  <?php foreach ($food_cat as $val):?>       
  <li <?php echo $x==1?'class="active"':'';?>><a href="#menu_tab_<?php echo $x;?>" data-toggle="tab"><?php echo $val['category_name']?></a></li>  
  <?php $x++;?>
  <?php endforeach;?>
  <?php endif;?>
</ul>
<?php endif;?>

<!-- Tab panes -->
<!--<div class="tab-content">
  <div class="tab-pane active" id="home">1</div>
  <div class="tab-pane" id="profile">2</div>
  <div class="tab-pane" id="messages">3</div>
  <div class="tab-pane" id="settings">4</div>
</div>-->

<?php if ( $layout_menu==4 || $layout_menu==5 || $layout_menu==7):?>
<?php if ( $layout_menu!=7 ):?>
 <div class="feature_menu menu_gallery" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
 <?php if ($featured=Yii::app()->functions->featuredFoodItem()):?>
 <ul class="da-thumbs" id="da-thumbs">
 <?php foreach ($featured as $val_f): ?>
  <li>
    <a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/item-id/".$val_f['item_id']?>">	      
	        <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val_f['photo'] ?>" alt="" title="">
	        <div class="menu_overlay">
             <h5><?php echo $val_f['item_name']?></h5>
            </div>	      
    </a>
  </li>
 <?php endforeach;?>
 </ul>
 <div class="clear"></div>
 <?php endif;?>
 </div>
 <?php endif;?>
<?php endif;?>

<?php if ( $layout_menu==10):?>
<?php if ($food_cat=yii::app()->functions->getCategory()): ?>

<div class="layout_<?php echo $layout_menu;?>">

<div data-uk-dropdown="{mode:'click'}" class="uk-button-dropdown">
    <button class="uk-button"><?php echo Yii::t("default","Menu")?> <i class="uk-icon-caret-down"></i></button>
    <div class="uk-dropdown" style="">
        <ul class="uk-nav uk-nav-dropdown">
            <?php foreach ($food_cat as $val):?> 
            <li><a href="#cat_<?php echo $val['cat_id']?>"  data-uk-smooth-scroll  ><?php echo $val['category_name']?></a></li>
            <?php endforeach;?>           
        </ul>
    </div>
</div>

<ul>
 <?php foreach ($food_cat as $val):?> 
 <!--<a href="#" class="parent-a">-->
 <li class="parent">
   <a href="#" class="parent-a">
   <span class="left" id="cat_<?php echo $val['cat_id']?>"><?php echo $val['category_name']?></span>
   <span class="right"><i class="fa fa-chevron-up"></i></span>
   <div class="clear"></div>
   </a>
 <!--</li>
 </a>-->
    <?php if ($food_item=yii::app()->functions->getFoodItem($val['cat_id'])):?>
    <ul class="child">
    <?php foreach ($food_item as $val):?>   
    <?php 
       if (!empty($val['price'])){
       	   $price=json_decode($val['price']);
       } else $price='';
       Yii::app()->functions->data="list";  
       $size=Yii::app()->functions->getSize();             
     ?>
    <li>  
    <a href="javascript:;" class="item-pop" rel="<?php echo $val['item_id']?>">
      <div class="uk-grid">	       
	       <div class="uk-width-1-2">
		        <div class="item-name">
		        <span class="uk-text-bold"><?php echo $val['item_name']?></span>
		        <p class="uk-text-muted"><?php echo $val['item_description']?></p>
		        </div>
	       </div>
	       <div class="uk-width-1-2 menu-price-wrap">
	       <?php if (is_array($price) && count($price)>=1):?>
	         <?php foreach ($price as $val_p):?>
	           <?php if (empty($val_p->size)):?>
	             <span class="item-price uk-text-bold"><?php echo baseCurr().prettyPrice($val_p->price)?></span>
	             <?php else :?>
	             <span class="item-price uk-text-bold">
	             <?php 
	             if (array_key_exists($val_p->size,(array)$size)){
             	     echo "<span class=\"uk-text-muted\" >".$size[$val_p->size]."</span>";
                 }	                  
	             ?>
	             <?php echo baseCurr().prettyPrice($val_p->price)?>
	             </span>
	           <?php endif;?>
	         <?php endforeach;?>
	       <?php endif;?>
	       </div>	       
      </div>
      </a>
    </li>
    <?php endforeach;?>
    </ul>
    </li>
    <!--</a>-->
    <?php endif;?>
 <?php endforeach;?>
</ul>
</div>
<?php endif;?>

<?php else :?>

<?php $x=1;?>
<div class="categorized_menu categorized_menu<?php echo $layout_menu;?> <?php echo $layout_menu==3?"collapsable":""?> <?php echo $layout_menu==5?"collapsable":""?> <?php echo $layout_menu==6?"tab-content":""?> <?php echo $layout_menu==7?"collapsable":""?> <?php echo $layout_menu==8?"collapsable":""?> <?php echo $layout_menu==9?"collapsable":""?>">
  <?php if ($food_cat=yii::app()->functions->getCategory()): ?>
  <?php foreach ($food_cat as $val):?>       
      <div id="<?php echo $layout_menu==6?"menu_tab_$x":"";?>" class="parent <?php echo $layout_menu==6?"tab-pane":"";?> <?php echo $layout_menu==6 && $x==1?"active":"";?> ">
      
      <?php if ( $layout_menu==3 || $layout_menu==5 || $layout_menu==7 || $layout_menu==8 || $layout_menu==9):?>            
	       <?php if ( $layout_menu==7 || $layout_menu==8):?>	       	       
           <a href="javascript:;" class="layout_7" >              
	         <div class="left item_thumb">
	           <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">
	         </div>	         
	         <div class="right cat_description">
	         <h5><?php echo $val['category_name']?> <i class="fa fa-chevron-up"></i></h5>
	         </div>
	         <div class="clear"></div>
	       </a>	       
	       <?php else :?>
	       <a href="javascript:;"><h5><?php echo $val['category_name']?> <i class="fa fa-chevron-up"></i></h5></a>
	       <?php endif;?>
       <?php else :?>
       <h5><?php echo $val['category_name']?></h5>
       <?php endif;?>
       
       <ul style="<?php echo $pre_collapse==1?"display:none;":"";?>" >       
       
       <?php if ($food_item=yii::app()->functions->getFoodItem($val['cat_id'])):?>
        <?php foreach ($food_item as $val):?>
        
       <?php 
       if (!empty($val['price'])){
       	   $price=json_decode($val['price']);
       } else $price='';
       Yii::app()->functions->data="list";
       $size=Yii::app()->functions->getSize();        
      ?>
        
      <!--<a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/item-id/".$val['item_id']?>">-->
        <li>
         <div class="left item_thumb">
         <?php if ( !empty($val['photo'])):?>
         <?php if ( $layout_menu == 8 || $layout_menu == 9):?>	 
         <?php else :?>
         <a href="<?php echo Yii::app()->request->baseUrl."/upload/".$food_item[0]['photo']?>" class="preview nolink" title="<?php echo $val['item_name']?>">
         <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">
         </a>
         <?php endif;?>
         <?php endif;?>
         </div>
         <div class="right description">
         <h6><?php echo $val['item_name']?></h6>
         <p><?php echo Yii::app()->functions->limitText($val['item_description'],100)?></p>         
         
         <div class="price_wrap">
         <?php if (is_array($price) && count($price)>=1):?>
          <?php foreach ($price as $val_p) :?>
           <div class="price">
           <?php if (!empty($val_p->size)):?>	                 
             <span><?php echo $size[$val_p->size];?></span>
             <?php else :?>	                 
             <?php
             if (array_key_exists($val_p->size,$size)){
             	echo $size[$val_p->size];
             }	                  
              ?>
           <?php endif;?>	                          
           <a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/item-id/".$val['item_id']."/size/".$val_p->size?>">
            <?php echo baseCurr().prettyPrice($val_p->price)?>
            </a>           
           </div>
          <?php endforeach;?>
        <?php endif;?>        
         </div> <!--END price_wrap-->
         
         </div> <!--END description-->
         
         <div class="clear"></div>
        </li>
        <!--</a>-->
        <?php endforeach;?>
       <?php endif;?>
       </ul>
  </div> <!--END parent-->
  <?php $x++;?>
  <?php endforeach;?>  
  <?php endif;?>  
  <div class="clear"></div>
</div> <!--END categorized_menu-->
<?php endif;?>

<?php endif;?>


<!--********************************
            END MENU
********************************-->


<!--********************************
            ADD TEXT  & IMAGES
********************************-->
<?php $promo_text_postion=Yii::app()->functions->getOption("promo_text_postion");?>
<?php if ( $promo_text_postion ==2 || $promo_text_postion ==""):?>
<?php
$add_text=Yii::app()->functions->getOption("add_text");
if ( !empty($add_text)){
	$add_text=json_decode($add_text);
}
?>
<?php if (is_array($add_text) && count($add_text)>=1):?>
<div class="promotional_wrap" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}" >
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
<?php endif;?>
<!--********************************
            END TEXT  & IMAGES
********************************-->


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
<?php
/*SEO*/
if ( $title=Yii::app()->functions->getOption('home_seo_title')){	
	$this->setPageTitle(ucwords($title));
	Yii::app()->clientScript->registerMetaTag($title, 'title');
	Yii::app()->clientScript->registerMetaTag($title, 'og:title');
}
if ( $home_meta_description=Yii::app()->functions->getOption("home_meta_description")){
	Yii::app()->clientScript->registerMetaTag($home_meta_description, 'description');
	Yii::app()->clientScript->registerMetaTag($home_meta_description, 'og:description');
}
if ( $home_meta_keywords=Yii::app()->functions->getOption("home_meta_keywords")){
	Yii::app()->clientScript->registerMetaTag($home_meta_keywords, 'keywords');
}