
<?php
$category_selected=array();
$price='';

if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{subcategory_item}}
	WHERE
	sub_item_id='".addslashes($_GET['id'])."'
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
    } else $data=array();
}
/*if (!isset($_GET['id'])){
	$_GET['id']='';
}*/
if (!isset($_GET['id'])){
	$_GET['id']='';
	$action='add';
} else $action='update';
?>

<div class="action_wrap">

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategoryitemnew" class="uk-button">
<i class="fa fa-plus"></i>
<?php echo Yii::t('default',"Add New")?>
</a>

<!--<a href="javascript:;" class="btn_delete_table uk-button">
<i class="fa fa-times"></i>
<?php echo Yii::t('default',"Delete")?>
</a>-->

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategoryitem" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/sortsubcategoryitem" class="uk-button">
<i class="fa fa-sort-alpha-asc"></i>
<?php echo Yii::t('default',"Sort Item")?>
</a>

</div>

<?php if (isset($_GET['msg'])):?>
<div class="success"><?php echo $_GET['msg']?></div>
<?php endif;?>


<form id="frm_item" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="id" value="<?php echo $_GET['id']?>">
<input type="hidden" name="action" value="subCategoryAdditem">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<input type="hidden" name="page_name" id="page_name" value="subcategoryitemnew">
<?php endif;?>


<div class="left indent_right">

<div class="input_block">
 <label><?php echo Yii::t('default',"AddOn Item")?> :</label>
 <input type="text" name="sub_item_name" data-validation="required" value="<?php echo $data['sub_item_name']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Description")?> :</label>
 <textarea name="item_description"><?php echo $data['item_description']?></textarea>
</div>

</div> <!--END LEFT-->

<div class="left">
   <div class="input_block">
   <label><?php echo Yii::t('default',"Status")?></label>
   <?php echo CHtml::dropDownList('status',$data['status'],status_list())?>
   </div>
   
   <div class="input_block">
   <label><?php echo Yii::t('default',"AddOn Category")?></label>
   <?php yii::app()->functions->data="list";?>
   <?php if ($cat=yii::app()->functions->getSubcategory()):?>   
        <?php foreach ($cat as $id=>$val):?>   	   
        <li><input type="checkbox" name="category[]" <?php yii::app()->functions->checkbox($id,$category_selected)?>  value="<?php echo $id;?>" data-validation="checkbox_group" data-validation-qty="min1" > <?php echo $val;?> </li>
        <?php endforeach;?>
   <?php else :?>
   <p>no <?php echo Yii::t('default',"category has been define")?>.</p>
   <?php endif;?>
   </div>
      
   <div class="input_block">
   <label><?php echo Yii::t('default',"Price")?></label>
   <?php echo chtml::textField('price',$data['price'],array('class'=>'small_input numeric_only'))?>
   </div>
   
    <div class="input_block">
	 <label><?php echo Yii::t('default',"Featured Image")?></label>	 	 
	  <div style="display:inline-table;margin-left:1px;" class="uk-button" id="photo"><?php echo Yii::t('default',"Browse")?></div>	  
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
	<label><?php echo Yii::t('default',"Preview")?></label>
	<div class="image_preview">
	 <?php if (!empty($data['photo'])):?>
	 <input type="hidden" name="photo" value="<?php echo $data['photo'];?>">
	 <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$data['photo'];?>?>" alt="" title="">
	 <?php endif;?>
	</div>
	</div>
   
</div><!-- END RIGHT-->
<div class="clear"></div>

<?php if ($action!="add"):?>
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" class="uk-button uk-button-success" >
<?php else:?>
<input type="submit" value="<?php echo Yii::t("default","Submit")?>" class="uk-button uk-button-success" >
<?php endif;?>
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategoryitem" class="uk-button">
<?php echo Yii::t('default',"Back")?></a>


</form>