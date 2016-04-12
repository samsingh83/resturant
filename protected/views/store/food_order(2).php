<?php if (!isset($_SESSION)) { session_start();} ?>
<div class="food_order">

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
    <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$food_item[0]['photo']?>" alt="" title="">	    
   <?php endif;?>
  
  </div> <!--END LEFT-->
  
  <form id="frm_item" method="POST" onsubmit="return false;">  
  <input type="hidden"  name="action" value="addToCart">  
  <input type="hidden"  name="item-id" value="<?php echo $_GET['item-id']?>"> 
  <input type="hidden" name="item_price" value="" id="item_price">
  <input type="hidden" name="item_row" value="<?php echo $_GET['row']?>" id="item_row">
  <div class="left item_description">
    <h1><?php echo $food_item[0]['item_name']?></h1>
    <div class="food_description"><p><?php echo $food_item[0]['item_description']?></p></div>
    
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
	      if ($_GET['size']==$val_price->size){
	      	 $ischecked=TRUE;
	      }
	      ?>      
	      <size><?php echo $size_words.$val_price->size;?></size>
	      <?php echo CHtml::radioButton('item_size',$ischecked,array('value'=>$val_price->size,'class'=>'item_size',
	      'price'=>$val_price->price))?>
	      <price><?php echo baseCurr().prettyPrice($val_price->price)?></price>
	      </li>
	    <?php endforeach;?>
	  </ul>   
	  <?php endif;?>
	  	  
	  <div class="extra_wrap">	    
	  <p class="info" style="display:block;">Click items to remove</p>
	   <!--<ul class="extras"><p>extras:</p>
	   <li>cheese</li><li>cheese</li></ul>
	   <ul class="toppings"><p>toppings:</p><li>tomato</li>
	   </ul>-->
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
                 <a class="added_addon" href="javascript:;">None</a>
             <?php endif;?>
             </li>
	         <?php endforeach;?>
	      <?php endif;?>	   
	    <?php endforeach;?>
	    <?php endif;?>	   
	    </ul>
	  </div>
	  <!--END extra_wrap-->
	  
	  <div class="order_notes_wrap">
	  <p>Notes:</p>
	  <textarea name="order_notes"><?php echo $data['order_notes']?></textarea>
	  </div>
	  
	  <div class="price_selected_wrap">
	    <span class="price_display"><!--$48.41--></span>
	    
	    <span class="quantityp">Quantity:</span>
	    <a href="#" class="qty_minus operator">-</a>
	    <input type="text" name="qty" id="qty" value="<?php echo $data['qty'];?>">
	    <a href="javascript:;" class="qty_add operator">+</a>	 
	    <?php if (isset($_GET['row'])):?>   
	       <a href="javascript:;" class="addtocart buttonorange">Update cart</a>
	    <?php else :?>
	       <a href="javascript:;" class="addtocart buttonorange">Add to cart</a>
	    <?php endif;?>	    
	    
	  </div>
	  <!--END price_selected_wrap-->
    
  </div> <!--END LEFT-->
  </form>
    
  
  <div class="clear"></div>
    
  
  <!--COOKING REFERECE-->  
  <div class="cooking_ref_wrap extras_wrap">
  <?php 
  $cooking_ref_desc=yii::app()->functions->getCookingref();     
  $cooking_ref='';
  if (!empty($food_item[0]['cooking_ref'])){
  	  $cooking_ref=json_decode($food_item[0]['cooking_ref']);  	  
  }  
  ?>
  <?php if (is_array($cooking_ref) && count($cooking_ref)>=1):?>
  <h2>Cooking Reference </h2>
  <ul>
  <?php foreach ($cooking_ref as $cooking_val):?>   
    <?php 
    $cooking_desc='';
    $is_select=false;
    if (array_key_exists($cooking_val,(array)$cooking_ref_desc)){
    	$cooking_desc=$cooking_ref_desc[$cooking_val];
    }
    if ($cooking_val==$data['cooking_ref']){
    	$is_select=true;
    }
    ?>
    <li><?php echo CHtml::radioButton('cooking_ref',$is_select,array('value'=>$cooking_val)).$cooking_desc?></li>
  <?php endforeach;?>   
    <div class="clear"></div>
  </ul>
  <?php endif;?>
  </div>
  
  <!--ADDON-->
  <div class="subcat_wrap extras_wrap">
  <?php   
  $subcat_item=to_json($food_item[0]['subcat_item']);    
  $subcategory_list=yii::app()->functions->getSubcategory();    
  $subcategory_item=yii::app()->functions->getSubcategoryItemFullDetails();        
  ?>
  <?php if (is_object($subcat_item) && count($subcat_item)>=1):?>  
  <h2>Add On</h2>
  <?php foreach ($subcat_item as $key=>$val):?>
    <ul><subitem><?php echo keyAndVal($key,$subcategory_list);?></subitem>
     <?php if (is_array($val) && count($val)>=1):?>
       <?php foreach ($val as $val_item): ?>
       <li class="item">
       <?php       
       if (array_key_exists($val_item,(array)$subcategory_item)){
       	   if (!empty($subcategory_item[$val_item]['photo'])){
       	   	   ?>
<a class="add_addon" href="javascript:;"  subcat_key="<?php echo $key?>" subcat="<?php echo keyAndVal($key,$subcategory_list);?>" addonid="<?php echo $val_item;?>" addonname="<?php echo $subcategory_item[$val_item]['sub_item_name']?>" price="<?php echo $subcategory_item[$val_item]['price']?>" >
<img src="<?php echo Yii::app()->request->baseUrl."/upload/".$subcategory_item[$val_item]['photo'] ?>"
alt="<?php echo $subcategory_item[$val_item]['sub_item_name']?>" 
title="<?php echo $subcategory_item[$val_item]['sub_item_name']?>">
</a>
       	   	   <?php
       	   }
       	   ?>
       	   <a class="add_addon" href="javascript:;" subcat="<?php echo keyAndVal($key,$subcategory_list);?>" addonid="<?php echo $val_item;?>" addonname="<?php echo $subcategory_item[$val_item]['sub_item_name']?>" price="<?php echo $subcategory_item[$val_item]['price']?>" >
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
  
 
<?php else :?>
  <?php echo notFound();?>
<?php endif;?>

</div> 
<!--food_order-->