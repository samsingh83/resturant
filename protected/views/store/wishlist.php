<?php yii::app()->functions->sessionInit();?>
<div class="uk-grid" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">
<div class="recent_order_wrap_page left">
<div class="recent_order_inner">
 <?php 
	$stmt="
	SELECT a.*,
	(
	select item_name from {{item}}
	where item_id=a.item_id
	) as item_name
	 FROM
	{{client_wishlist}} a
	WHERE client_id='".addslashes(Yii::app()->functions->userId())."'
	ORDER BY id DESC
	LIMIT 0,100
	";       		
	$connection=Yii::app()->db;		
	$rows=$connection->createCommand($stmt)->queryAll();
 ?>    
	    <?php if (is_array($rows) && count($rows)>=1):?>
	    <div class="recent_order_wrap">
	    	<h3><span class="glyphicon glyphicon-th-list"></span> <?php echo Yii::t('default',"Wishlist")?></h3>
	    	<div class="inner">
	    	<ul class="wisht_list_ul">
	    	<?php foreach ($rows as $val):?>
	    	<li class="wr_<?php echo $val['id']?>"><a href="<?php echo Yii::app()->request->baseUrl."/store/food-order/?item-id=".$val['item_id'] ?>"><i class="fa fa-heart-o"></i> <?php echo $val['item_name']?></a>
	    	<a href="javascript:;" class="right wishlist_remove" rev="<?php echo $val['id']?>"><i class="fa fa-trash-o"></i></a>
	    	</li>
	    	<?php endforeach;?>
	    	</ul>
	    	</div>
	    </div>	
	    <?php else :?>	    	        
		    <?php if (Yii::app()->functions->isUserLoggedIn()):?>
		    <p class="uk-alert"><?php echo Yii::t('default',"Your Wishlist is empty")?></p>
		    <?php else :?>
		     <p class="uk-alert"><?php echo Yii::t('default',"Please login")?> <a data-target=".pop_login" data-toggle="modal" href="javascript:;"><?php echo Yii::t('default',"here")?></a></p>
		    <?php endif;?>
	    <?php endif;?>    
</div>
</div> <!--END recent_order_wrap-->

<div class="siderbar_wrap right">
 <?php Yii::app()->functions->categoryMenu()?>
</div> <!--END siderbar_wrap-->
<div class="clear"></div>
</div>