<?php if (!isset($_SESSION)) { session_start();} ?>
<div class="uk-grid" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="food_order left">

<?php if ($food_item=yii::app()->functions->getFoodItemDetails($_GET['item-id'])): ?> 
  <?php   
  $price='';
  if (!empty($food_item[0]['price'])){
  	  $price=json_decode($food_item[0]['price']);  	    	 
  }  
  yii::app()->functions->data="list";
  $size=yii::app()->functions->getSize();  
  ?>
  
  <div class="left item_photo">  
   <?php if (!empty($food_item[0]['photo'])):?>   
    <a href="<?php echo Yii::app()->request->baseUrl."/upload/".$food_item[0]['photo']?>" class="preview nolink" title="<?php echo $food_item[0]['item_name']?>" >
    <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$food_item[0]['photo']?>" alt="" title="">	    
    </a>
   <?php endif;?>
  
  <!--COOKING REFERECE-->  
  <div class="cooking_ref_wrap extras_wrap">
  <?php 
  $cooking_ref_desc=yii::app()->functions->getCookingref();     
  $cooking_ref='';
  if (!empty($food_item[0]['cooking_ref'])){
  	  $cooking_ref=json_decode($food_item[0]['cooking_ref']);  	  
  }    
  
  $temp_data_cooking_ref=0;
  if (isset($_GET['row'])){	
  	  if (array_key_exists($_GET['row'],(array)$_SESSION[KARENDERIA]['item'])){
  	  	  $temp_data=$_SESSION[KARENDERIA]['item'][$_GET['row']];
  	  	  $temp_data_cooking_ref=$temp_data['cooking_ref'];
  	  } else unset($_GET['row']);	  
  }  
  ?>
  <?php if (is_array($cooking_ref) && count($cooking_ref)>=1):?>
  <h2><?php echo Yii::t('default',"Cooking Preference")?> </h2>
  <ul>
  <?php foreach ($cooking_ref as $cooking_val):?>   
    <?php 
    $cooking_desc='';
    $is_select=false;
    if (array_key_exists($cooking_val,(array)$cooking_ref_desc)){
    	$cooking_desc=$cooking_ref_desc[$cooking_val];
    }
    //if ($cooking_val==$data['cooking_ref']){
    if ($cooking_val==$temp_data_cooking_ref){
    	$is_select=true;
    }
    ?>
    <li><?php echo CHtml::radioButton('cooking_ref',$is_select,
    array('value'=>$cooking_val,'class'=>'cooking_ref')).$cooking_desc?></li>
  <?php endforeach;?>   
    <div class="clear"></div>
  </ul>
  <?php endif;?>
  </div>
  <!-- END COOKING REF-->
      
  
  <?php $page_url=Yii::app()->functions->currentPageUrl()?>
  
  <div class="share_wrapper">
  <a href="javascript:;" rel="https://www.facebook.com/sharer/sharer.php?u=<?php echo $page_url?>&display=popup&title=hamburger&summary=test summary" class="social fb_share"><?php echo Yii::t('default',"Share this on facebook")?></a>
  <?php if (Yii::app()->functions->isUserLoggedIn()):?>    
  <?php endif;?>
  <input type="hidden" name="trans_type" id="trans_type" value="add_wishlist">  
  <a href="javascript:;" <?php echo display(true);?> class="add_fav" rev="<?php echo $_GET['item-id']?>" ><?php echo Yii::t('default',"Add to my Wishlist")?></a>  
  
  <?php if ( Yii::app()->functions->getOption("allowed_ordering")==2 ):?>
  <?php else :?>
  <a href="javascript:;" <?php echo display(false);?> class="add_favs" data-toggle="modal" data-target=".pop_login" ><?php echo Yii::t('default',"Add to my Wishlist")?></a>
  <?php endif;?>
  
  </div> <!--END share_wrapper-->
  
   
  </div> <!--END LEFT-->
  
  <form id="frm_item" method="POST" onsubmit="return false;">  
  <input type="hidden"  name="action" value="addToCart">  
  <input type="hidden"  name="item-id" value="<?php echo $_GET['item-id']?>"> 
  <input type="hidden" name="item_price" value="" id="item_price">
  <input type="hidden" name="item_row" value="<?php echo isset($_GET['row'])?$_GET['row']:""?>" id="item_row">
  <div class="left item_description" style="width:350px;">
    <h1><?php echo $food_item[0]['item_name']?></h1>
    <div class="food_description"><p><?php echo $food_item[0]['item_description']?></p></div>
    
    <?php 
    /*ADD META TAGS*/
    $title=yii::app()->functions->getOption('store_name')." - ".strip_tags($food_item[0]['item_name']);
    $this->setPageTitle(ucwords($title));
    Yii::app()->clientScript->registerMetaTag($food_item[0]['item_name'], 'title');
    Yii::app()->clientScript->registerMetaTag($food_item[0]['item_description'], 'description');
    Yii::app()->clientScript->registerMetaTag($food_item[0]['item_description'], 'keywords');
    
    Yii::app()->clientScript->registerMetaTag($food_item[0]['item_name'], 'og:title');
    Yii::app()->clientScript->registerMetaTag('article', 'og:type');
    Yii::app()->clientScript->registerMetaTag(CHtml::encode($this->pageTitle), 'og:site_name');
    Yii::app()->clientScript->registerMetaTag($food_item[0]['item_description'], 'og:description');
    Yii::app()->clientScript->registerMetaTag("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'og:url');
    Yii::app()->clientScript->registerMetaTag("http://".$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl."/upload/".$food_item[0]['photo'], 'og:image');
    ?>
    
      <?php 
      /*WHEN EDIT CART MODE*/
	  $subcategory_list=yii::app()->functions->getSubcategory(); 
	  $subcategory_item=yii::app()->functions->getSubcategoryItemFullDetails();
	  $data['qty']=1;
	  $data['order_notes']='';
	  $data['item_size']='';
	  $data['cooking_ref']='';
	  $addon='';
	  if (isset($_GET['row'])){	  	  
	  	  $data=$_SESSION[KARENDERIA]['item'][$_GET['row']];	  	  
	  	  $addon=!empty($data['addon'])?json_decode($data['addon']):false;	  	  
	  	  if ($addon!=FALSE){                	   
              foreach ($addon as $addon_val) {                       
                 $addon_item[$addon_val->subcat_id]['item'][]=$addon_val->item[0];    		
              }
          }
	  }
	  //dump($data);
	  //dump($addon_item);
	  //dump($subcategory_item);
	  ?>
	  
	  
      <!--PRICE-->            
	  <?php if (is_array($price) && count($price)>=1):?>
	  <?php 
      $ischecked=false;      
      if (count($price)==1 && $price[0]->size==""){
      	  $ischecked=TRUE;
      }      
      ?>
	  <ul class="price">
	    <?php foreach ($price as $val_price):?>
	      <li>
	      <?php 
	      $ischecked=false;  
	      $size_words='';
	      if (array_key_exists($val_price->size,(array)$size)){
	      	   $size_words=$size[$val_price->size];
	      }	      
	      if ($data['item_size']==$val_price->size){
	      	 $ischecked=TRUE;
	      }	      
	      
	      if (isset($_GET['size'])){
	      if ($_GET['size']==$val_price->size){
	      	 $ischecked=TRUE;
	      }
	      }
	      ?>      
	      <size><?php echo $size_words?></size>
	      <?php echo CHtml::radioButton('item_size',$ischecked,array('value'=>$val_price->size,'class'=>'item_size',
	      'price'=>$val_price->price))?>
	      <price><?php echo baseCurr().prettyPrice($val_price->price)?></price>
	      </li>
	    <?php endforeach;?>
	  </ul>   
	  <?php endif;?>

	  <?php 
	  if (!isset($addon_item)){
	  	  $addon_item='';
	  }
	  ?>  
	  
	  <div class="extra_wrap">	    
	  
	  <?php if ( Yii::app()->functions->getOption("allowed_ordering")==2 ):?>
	  <?php else :?>
	  <p class="info" style="display:block;"><?php echo Yii::t('default',"Click items to remove")?></p>
	  <?php endif;?>
	  	  
	    <ul class="extras">
	    <?php if (is_array($addon_item) && count($addon_item)>=1):?>
	    <?php foreach ($addon_item as $key=>$addon_val): ?>
	      <?php if (array_key_exists($key,$subcategory_list)):?>
	         <p><?php echo $subcategory_list[$key]?></p>
	         <?php else :?>
	         <p>None</p>
	      <?php endif;?>
	      <?php if (is_array($addon_val['item'])&& count($addon_val['item'])>=1):?>
	         <?php foreach ($addon_val['item'] as $addonitem):?>
             <li subcat_key="<?php echo $key;?>" price="<?php echo $addonitem->price?>" addon_id="<?php echo $addonitem->addon_id?>">
             <?php if (array_key_exists($addonitem->addon_id,$subcategory_item)):?>             
                 <a class="added_addon" href="javascript:;"><?php echo $subcategory_item[$addonitem->addon_id]['sub_item_name'];?></a>
             <?php else :?>
                 <a class="added_addon" href="javascript:;"><?php echo Yii::t('default',"None")?></a>
             <?php endif;?>
             </li>
	         <?php endforeach;?>
	      <?php endif;?>	   
	    <?php endforeach;?>
	    <?php endif;?>	   
	    </ul>
	  </div>
	  <!--END extra_wrap-->
	  
	  <?php if ( Yii::app()->functions->getOption("allowed_ordering")==2 ):?>
	 <?php else :?>
		
	  <?php $disabled_notes=Yii::app()->functions->getOption("disabled_notes");?> 
	  <?php if ($disabled_notes==""):?>
		  <div class="order_notes_wrap">
		  <p><?php echo Yii::t("default","Notes")?>:</p>
		  <textarea name="order_notes"><?php echo $data['order_notes']?></textarea>
		  </div>
	  <?php endif;?>
	  
	  
	<!--MULTI OPTIONS-->
	  <?php $multi_id_selected=isset($data['multi_id'])?$data['multi_id']:""; ?>
	  <?php $multi_description=Yii::app()->functions->getMultiOptionList(); ?>
	  <?php $multi_opt=isset($food_item[0]['multi_id'])?json_decode($food_item[0]['multi_id']):false;?>
	  <?php if ( $multi_opt !=FALSE ):?>
	  <?php echo CHtml::hiddenField('multi_option_number',$food_item[0]['multi_option_number'])?>
	  <div class="multi_options_wrap">
	  <h2><?php echo Yii::t('default',$food_item[0]['multi_option_title'])?> </h2>
	  <?php foreach ($multi_opt as $multi_val):?>
	    <?php 
	    $ischeck=false;
	    if (in_array($multi_val,(array)$multi_id_selected)){
	    	$ischeck=true;
	    }
	    ?>
	    <?php if ( array_key_exists($multi_val,(array)$multi_description)):?>
	    <li><?php echo CHtml::checkBox('multi_id[]',$ischeck,
	    array('value'=>$multi_val,'class'=>'multi_id'))."<span>".$multi_description[$multi_val]."</span>"?></li>
	    <?php endif;?>
	    
	  <?php endforeach;?>
	  </div>
	  <?php endif;?>
	  <!--MULTI OPTIONS-->
	  
	  <div class="price_selected_wrap">
	    <span class="price_display"><!--$48.41--></span>
	    
	    <span class="quantityp"><?php echo Yii::t('default',"Quantity")?>:</span>
	    <a href="#" class="qty_minus operator">-</a>
	    <input type="text" name="qty" id="qty" value="<?php echo $data['qty'];?>">
	    <a href="javascript:;" class="qty_add operator">+</a>	 
	    <?php if (isset($_GET['row'])):?>   
	       <a href="javascript:;" class="addtocart buttonorange"><?php echo Yii::t('default',"Update cart")?></a>
	    <?php else :?>
	       <a href="javascript:;" class="addtocart buttonorange"><?php echo Yii::t('default',"Add to cart")?></a>
	    <?php endif;?>	    
	    
	  </div>
	  <!--END price_selected_wrap-->
	  
	  
	 <?php endif;?>
    
  </div> <!--END LEFT-->
  </form>
    
  
  <div class="clear"></div>
     
  <!--ADDON-->
  <div class="subcat_wrap extras_wrap">
  <?php   
  $subcat_item=to_json($food_item[0]['subcat_item']);    
  $subcategory_list=yii::app()->functions->getSubcategory();    
  $subcategory_item=yii::app()->functions->getSubcategoryItemFullDetails();        
  ?>
  <?php if (is_object($subcat_item) && count($subcat_item)>=1):?>  
  <h2><?php echo Yii::t('default',"Add On")?></h2>
  <?php foreach ($subcat_item as $key=>$val):?>
    <ul><subitem><?php echo keyAndVal($key,$subcategory_list);?></subitem>
     <?php if (is_array($val) && count($val)>=1):?>
       <?php foreach ($val as $val_item): ?>
       <li class="item">
       <?php       
       if (array_key_exists($val_item,(array)$subcategory_item)){
       	   $current_id=clean_string(keyAndVal($key,$subcategory_list));
       	   if (!empty($subcategory_item[$val_item]['photo'])){
       	   	   ?>
<a rel="<?php echo $current_id;?>" class="add_addon" href="javascript:;"  subcat_key="<?php echo $key?>" subcat="<?php echo keyAndVal($key,$subcategory_list);?>" addonid="<?php echo $val_item;?>" addonname="<?php echo $subcategory_item[$val_item]['sub_item_name']?>" price="<?php echo $subcategory_item[$val_item]['price']?>" >
<img src="<?php echo Yii::app()->request->baseUrl."/upload/".$subcategory_item[$val_item]['photo'] ?>"
alt="<?php echo $subcategory_item[$val_item]['sub_item_name']?>" 
title="<?php echo $subcategory_item[$val_item]['sub_item_name']?>">
</a>
       	   	   <?php
       	   }
       	   ?>
       	   <a rel="<?php echo $current_id;?>" class="add_addon" href="javascript:;" subcat_key="<?php echo $key?>" subcat="<?php echo keyAndVal($key,$subcategory_list);?>" addonid="<?php echo $val_item;?>" addonname="<?php echo $subcategory_item[$val_item]['sub_item_name']?>" price="<?php echo $subcategory_item[$val_item]['price']?>" >
       	   <?php echo $subcategory_item[$val_item]['sub_item_name'];?>
       	   </a>
       	   <div class="price"><?php echo baseCurr().prettyPrice($subcategory_item[$val_item]['price'])?></div>
       	   <?php      	          	   
       }
       ?>
       </li>
       <?php endforeach;?>  	  
     <?php endif;?>
     <div class="clear"></div>
    </ul> 
  <?php endforeach;?>  	  
  <?php endif;?>
  </div>
  
  <!--MORE ITEM-->
  <?php if ($item=yii::app()->functions->getFoodItemDetails($_GET['item-id'])):?>
  <?php $category=!empty($item[0]['category'])?json_decode($item[0]['category']):false;?>
  <?php if ($same_item=yii::app()->functions->getSameItem($category[0])):?>      
  <div class="item_same_cat_wrap">
   <h4><span class="glyphicon glyphicon-th-list"></span><?php echo count($same_item);?> <?php echo Yii::t('default',"other products in the same category")?>:</h4>
   <div class="inner">        
      <ul class="more_item_bxslider">
      <?php foreach ($same_item as $val_item): //dump($val_item); ?>
      <?php 
      $price=!empty($val_item['price'])?json_decode($val_item['price']):false;      
      if ($price!=FALSE){
      	  $price=baseCurr().prettyPrice($price[0]->price);
      }
      ?>
      <li>        
       <a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/?item-id=".$val_item['item_id']?>">
          <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val_item['photo']?>" alt="<?php echo $val_item['item_name']?>" title="<?php echo ucwords($val_item['item_name']) . " ". $price?>">
       </a>
      </li>
      <?php endforeach;?>
      </ul>
   </div>
  </div> <!--END item_same_cat_wrap-->
  <?php endif;?>
  <?php endif;?>
  <!--MORE ITEM-->
 
<?php else :?>
  <?php echo notFound();?>
<?php endif;?>

</div> 
<!--food_order-->



<div class="siderbar_wrap right">
 <div class="recent_order_inner">
 <?php Yii::app()->functions->recentOrderWidget()?>
 </div>
 <?php Yii::app()->functions->categoryMenu()?>
</div> <!--END siderbar_wrap-->

</div> <!--END uk-grid-->

<div class="clear"></div>