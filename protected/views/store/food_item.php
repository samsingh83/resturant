<?php if (!isset($_SESSION)) { session_start();} ?>
<div class="food_cat left">
<div class="uk-grid" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<?php if ($food_item=yii::app()->functions->getFoodItem($_GET['cat-id'])): ?>
     <ul>
      <?php foreach ($food_item as $val): //dump($val);?>
      <?php 
       if (!empty($val['price'])){
       	   $price=json_decode($val['price']);
       } else $price='';
       Yii::app()->functions->data="list";
       $size=Yii::app()->functions->getSize();        
      ?>
      <li>             
          <div class="food_wrap">	      
            <a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/item-id/".$val['item_id']?>">	      
	        <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">	    
	        </a>
	        <div class="food_wrap_inner food_wrap_inner_fixed">
	          <a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/item-id/".$val['item_id']?>">	      
	          <h2><?php echo $val['item_name']?></h2> 	          	          
	          </a>
	          
	          <div class="left">
	            <?php if (is_array($price) && count($price)>=1):?>
	              <?php foreach ($price as $val_p) :?>
	               <div>
	               <?php if (!empty($val_p->size)):?>	                 
	                 <span><?php echo $size[$val_p->size];?></span>
	                 <?php else :?>	                 
	                 <?php
	                 if (array_key_exists($val_p->size,$size)){
	                 	echo $size[$val_p->size];
	                 }	                  
	                  ?>
	               <?php endif;?>	               
	               <price>
	               <a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/item-id/".$val['item_id']."/size/".$val_p->size?>">
	                <?php echo baseCurr().prettyPrice($val_p->price)?>
	                </a>
	               </price>
	               </div>
	              <?php endforeach;?>
	            <?php endif;?>
	          </div>	          
	          <div class="clear"></div>
	          
	        </div> <!--food_wrap_inner-->	      
	     </div> <!--food_wrap-->	  
      </li>
      <?php endforeach;?>
     </ul>
     <div class="clear"></div>
<?php else :?>
 <p class="alert alert-warning"><?php echo Yii::t('default',"Food category is empty")?></p>
<?php endif;?>

  <!--MORE ITEM-->
  <?php if ($res=Yii::app()->functions->getSameCategory($_GET['cat-id'])):?>
  <div class="item_same_cat_wrap">
  <h4><span class="glyphicon glyphicon-th-list"></span><?php echo Yii::t('default',"More food category")?></h4>
  <div class="inner"> 
  <ul class="more_item_bxslider">
    <?php foreach ($res as $val_item): //dump($val_item); ?>
    <li>
     <a href="<?php echo Yii::app()->request->baseUrl."/store/food-item/?cat-id=".$val_item['cat_id']?>">
       <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val_item['photo']?>" alt="<?php echo $val_item['category_name']?>" title="<?php echo ucwords($val_item['category_name'])?>">
       </a>
    </li>
    <?php endforeach;?>
  </ul>
  </div>
  </div>
  <?php endif;?>
  <!--MORE ITEM-->
  </div> <!--END uk-grid-->
</div> <!--END food_cat_left-->

<div class="siderbar_wrap right">
 <div class="recent_order_inner">
 <?php Yii::app()->functions->recentOrderWidget()?>
 </div>
 <?php Yii::app()->functions->categoryMenu()?>
</div> <!--END siderbar_wrap-->

<div class="clear"></div>

<?php
/* SEO */
$category_name='';
$category_description='';
if (isset($_GET['cat-id'])){
	if ($cat=Yii::app()->functions->getCategoryById($_GET['cat-id'])){    					
		$category_name=$cat[0]['category_name'];
		$$category_description=$cat[0]['category_description'];
	}
}
$title=yii::app()->functions->getOption('store_name')." - ".$category_name;
$this->setPageTitle(ucwords($title));
Yii::app()->clientScript->registerMetaTag($title, 'og:title');

Yii::app()->clientScript->registerMetaTag($category_description, 'description');
Yii::app()->clientScript->registerMetaTag($category_description, 'og:description');