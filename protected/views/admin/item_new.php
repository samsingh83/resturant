
<?php
$category_selected=array();
$price='';
$subcat_item=array();
$cooking_ref_data=array();

if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{item}}
	WHERE
	item_id='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll(); 
    if (is_array($rows) && count($rows)>=1){    	    	
    	$data=$rows[0];    
    	$category_selected=$data['category'];
    	if (!empty($category_selected)){
    		$category_selected=json_decode($category_selected);    		
    	}
    	if (!empty($data['price'])){
    		$price=json_decode($data['price']);
    	}
    	if (!empty($data['subcat_item'])){
    		$subcat_item=(array)json_decode($data['subcat_item']);
    	}
    	if (!empty($data['cooking_ref'])){
    		$cooking_ref_data=json_decode($data['cooking_ref']);
    	}
    } else $data=array();
}
?>


<div class="action_wrap" id="item_new_wrap">

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/itemnew" class="uk-button">
 <i class="fa fa-plus"></i>
 <?php echo Yii::t('default',"Add New")?>
</a>

<!--<a href="javascript:;" class="btn_delete_table uk-button">
 <i class="fa fa-times"></i>
 <?php echo Yii::t('default',"Delete")?>
</a>-->

<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/item" class="uk-button">
<i class="fa fa-list"></i> <?php echo Yii::t("default","List")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/sortitem" class="uk-button">
 <i class="fa fa-sort-alpha-asc"></i>
<?php echo Yii::t('default',"Sort Item")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/featureditem" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"Featured Item")?>
</a>

</div>

<?php if (isset($_GET['msg'])):?>
<div class="success"><?php echo $_GET['msg']?></div>
<?php endif;?>

<form id="frm_item" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="id" value="<?php echo $data['item_id']?>">
<input type="hidden" name="action" value="addItem">
<?php if (!isset($_GET['id'])):?>
<input type="hidden" name="clear" id="clear" value="true">
<input type="hidden" name="page_name" id="page_name" value="itemnew">
<?php endif;?>


<div class="left indent_right">

<div class="input_block">
 <label><?php echo Yii::t("default","Food Item Name")?> :</label>
 <input type="text" name="item_name" data-validation="required" value="<?php echo $data['item_name']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t("default","Description")?> :</label>
 <!--<textarea name="item_description"><?php echo $data['item_description']?></textarea>-->
 <?php echo CHtml::textArea('item_description',$data['item_description'])?>
</div>


   <div class="addon_wrap">
	<h4><?php echo Yii::t("default","AddOn")?></h4>
	<?php if ($subcat_list=yii::app()->functions->subcategoryList()):?>
	    <ul>
		<?php foreach ($subcat_list as $val): ?>
		<li><?php /*echo chtml::checkBox("subcat_id[$val[subcat_id]][]",
		false,array('value'=>$val['subcat_id']));*/ echo $val['subcategory_name']?></li>
		    <?php if (is_array($val['sub_item']) && count($val['sub_item'])>=1):?>
		        <ul>
		        <?php foreach ($val['sub_item'] as $val2): //dump($val2);?>
		          <?php 
		          $chk=false;	
		          $selected='';			
		          if (is_array($subcat_item) && count($subcat_item)>=1){         
			          foreach ($subcat_item as $key => $valcat) {		          	  
			          	  if ($key==$val['subcat_id']){
			          	  	  $selected=$valcat;
			          	  }
			          }		          
		          }
		          if (in_array($val2['sub_item_id'],(array)$selected)){
		          	   $chk=TRUE;
		          }
		          if (!empty($val2['sub_item_name'])):
		          ?>
		          <li><?php echo chtml::checkBox("sub_item_id[$val[subcat_id]][]",
		          $chk,array('value'=>$val2['sub_item_id'])); echo "<span>".$val2['sub_item_name']."</span>";?></li>
		          <?php endif;?>
		        <?php endforeach;?>
		        </ul>
		    <?php endif;?>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
	</div>

</div> <!--END LEFT-->

<div class="left">
   <div class="input_block">
   <label><?php echo Yii::t("default","Status")?></label>
   <?php echo CHtml::dropDownList('status',$data['status'],status_list())?>
   </div>
   
   <div class="input_block">
   <label class="uk-h3"><?php echo Yii::t("default","Food Category")?></label>
   <?php yii::app()->functions->data="list";?>
   <?php if ($cat=yii::app()->functions->getCategory()):?>   
        <?php foreach ($cat as $id=>$val):?>   	   
        <li><input type="checkbox" name="category[]" <?php yii::app()->functions->checkbox($id,$category_selected)?>  value="<?php echo $id;?>" data-validation="checkbox_group" data-validation-qty="min1" > <?php echo $val;?> </li>
        <?php endforeach;?>
   <?php else :?>
   <p><?php echo Yii::t("default","no category has been define.")?></p>
   <?php endif;?>
   </div>
   
   <div class="input_block">
   <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
   <tr>
   <td><?php echo Yii::t("default","Size")?></td>
   <td><?php echo Yii::t("default","Price")?></td>   
   </tr>
         
   <?php 
   if (!is_array($price)){
   	   $price=array();
   }
   ?>
   <?php for ($x=0; $x<=4; $x++):?>
   <tr>
   <td>   
   <?php echo CHtml::dropDownList('size[]',   
   array_key_exists($x,(array)$price)?$price[$x]->size:""
   ,(array)yii::app()->functions->getSize())?>   
   </td>
   <td>   
   <?php echo CHtml::textField('price[]',   
   array_key_exists($x,(array)$price)?$price[$x]->price:""
   ,array('class'=>'small_input numeric_only')) ?>   
   </td>
   </tr>   
   <?php endfor;?>
   
   </table>
   </div>
   
   <div> <!--DISCOUNT-->
   <div class="input_block">
   <label><?php echo Yii::t("default","Discount (numeric value)")?></label>
   <?php echo CHtml::textField('discount',$data['discount'],array('class'=>'small_input numeric_only'))?>   
   </div>   
   </div> <!--DISCOUNT-->
   
    <!--IMAGE-->
    <div class="input_block">
	 <label><?php echo Yii::t("default","Featured Image")?></label>	 	 
	  <div style="display:inline-table;margin-left:1px;" class="button" id="photo"><?php echo Yii::t("default","Browse")?></div>	  
	  <DIV  style="display:none;" class="photo_chart_status" >
		<div id="percent_bar" class="photo_percent_bar"></div>
		<div id="progress_bar" class="photo_progress_bar">
		  <div id="status_bar" class="photo_status_bar"></div>
		</div>
	  </DIV>		  
	</div>

	<?php if (!empty($data['photo'])):?>
	<div class="input_block">
	<?php else :?>
	<div class="input_block preview">
	<?php endif;?>
	<label><?php echo Yii::t("default","Preview")?></label>
	<div class="image_preview">
	<?php if (!empty($data['photo'])):?>
	<input type="hidden" name="photo" value="<?php echo $data['photo'];?>">
	<img src="<?php echo Yii::app()->request->baseUrl."/upload/".$data['photo'];?>?>" alt="" title="">
	<?php endif;?>
	</div>
	</div>
	<!--IMAGE-->

   <div class="cookingref_wrap"> <!--COOKING REFERENCE-->
   <h4 class="uk-h3"><?php echo Yii::t("default","Cooking Reference")?></h4>
   <?php    
   $cooking_ref=yii::app()->functions->getCookingref();   
   if (is_array($cooking_ref) && count($cooking_ref)>=1){
   	  foreach ($cooking_ref as $cook_id=>$val_cokref) { 
   	  	$chk=false;   	  	
   	  	if (in_array($cook_id,(array)$cooking_ref_data)){   	  		
   	  		$chk=true;
   	  	}
   	  	echo "<li>";
   	  	echo CHtml::checkBox('cooking_ref[]',$chk,array('value'=>$cook_id))."<span>$val_cokref</span>";
   	  	echo "</li>";
   	  }
   }
   ?>
   </div><!-- COOKING REFERENCE-->
   
   <div class="multi_option_wrap"> <!--MULTI OPTIONS-->
   <h4 class="uk-h3"><?php echo Yii::t("default","Multi Options")?></h4>
   
   <div class="input_block">
   <label><?php echo Yii::t("default","Multi Option Title") ?></label>
   <?php 
   echo CHtml::textField('multi_option_title',
   isset($data['multi_option_title'])?$data['multi_option_title']:""
   ,array(
     'class'=>"small_input"
   ));
   ?>
   </div>
   
   <div class="input_block">
   <label><?php echo Yii::t("default","How Many Option Can be Selected?") ?></label>
   <?php 
   echo CHtml::textField('multi_option_number',
   isset($data['multi_option_number'])?$data['multi_option_number']:""
   ,array(
     'class'=>"extra_small_input numeric_only"
   ));
   ?>
   </div>
   
   <?php $multi_data= isset($data['multi_id'])?json_decode($data['multi_id']):false;?>
   <?php $multi_opt=yii::app()->functions->getMultiOptionList(); ?>     
   <?php
   if (is_array($multi_opt) && count($multi_opt)>=1){
   	  foreach ($multi_opt as $multi_id=>$val_multi) { 
   	  	$chk=false;   	  	
   	  	if (in_array($multi_id,(array)$multi_data)){   	  		
   	  		$chk=true;
   	  	}
   	  	echo "<li>";
   	  	echo CHtml::checkBox('multi_id[]',$chk,array('value'=>$multi_id))."<span>$val_multi</span>";
   	  	echo "</li>";
   	  }
   }
   ?>
   </div> <!--MULTI OPTIONS-->

   
</div><!-- END RIGHT-->
<div class="clear"></div>


<?php if (isset($_GET['id'])):?>
<input type="submit" value="<?php echo Yii::t("default","Update")?>" class="uk-button uk-button-success" >
<?php else:?>
<input type="submit" value="<?php echo Yii::t("default","Submit")?>" class="uk-button uk-button-success" >
<?php endif;?>	
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/item" class="uk-button"><?php echo Yii::t("default","Back")?></a>

</form>