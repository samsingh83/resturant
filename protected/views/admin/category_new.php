<?php
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{category}}
	WHERE
	cat_id='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll(); 
    if (is_array($rows) && count($rows)>=1){    	
    	$data=$rows[0];    	
    } else $data=array();
}
?>


<div class="action_wrap">
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/categorynew" class="uk-button">
<i class="fa fa-plus"></i><?php echo Yii::t('default',"Add New")?>
</a>

<!--<a href="javascript:;" class="uk-button btn_delete_table">
<i class="fa fa-times"></i>
<?php echo Yii::t('default',"Delete")?>
</a>-->

<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/category" class="uk-button">
<i class="fa fa-list"></i> <?php echo Yii::t("default","List")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/sortcategory" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"Sort Category")?>
</a>
</div>

<?php if (isset($_GET['msg'])):?>
<div class="success"><?php echo $_GET['msg']?></div>
<?php endif;?>

<form id="frm_category" method="POST" class="uk-form uk-form-horizontal forms has-validation-callback" >
<input type="hidden" name="id" value="<?php echo $data['cat_id']?>">
<input type="hidden" name="action" value="addCategory">
<?php if (!isset($_GET['id'])):?>
<input type="hidden" name="clear" id="clear" value="true">
<input type="hidden" name="page_name" id="page_name" value="category-new">
<?php endif;?>

<div class="input_block">
 <label><?php echo Yii::t('default',"Food Category Name")?> :</label>
 <input type="text"  name="category_name" data-validation="required" value="<?php echo $data['category_name']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Description")?> :</label>
 <!--<input name="category_description" value="<?php echo $data['category_description']?>" >-->
 <?php echo CHtml::textArea('category_description',$data['category_description'])?>
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

<div class="input_block">
   <label><?php echo Yii::t('default',"Status")?></label>
   <?php echo CHtml::dropDownList('status',$data['status'],status_list())?>
</div>


<div class="input_block">
<?php if (isset($_GET['id'])):?>
<input type="submit" value="Update" class="uk-button uk-button-success" >
<?php else:?>
<input type="submit" value="submit" class="uk-button uk-button-success" >
<?php endif;?>
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/category" class="uk-button"><?php echo Yii::t('default',"Back")?></a>
</div>

</form>