<?php
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{subcategory}}
	WHERE
	subcat_id='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";	
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll();     
    if (is_array($rows) && count($rows)>=1){    	
    	$data=$rows[0];    	
    } else $data=array();
}

if (!isset($_GET['id'])){
	$_GET['id']='';
	$action='add';
} else $action='update';
?>

<div class="action_wrap">


<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategorynew" class="uk-button">
<i class="fa fa-plus"></i>
<?php echo Yii::t('default',"Add New")?>
</a>

<!--<a href="javascript:;" class="btn_delete_table uk-button">
<i class="fa fa-times"></i>
<?php echo Yii::t("default","Delete")?>
</a>-->

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategory" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/sortsubcategory" class="uk-button">
<i class="fa fa-sort-alpha-asc"></i>
<?php echo Yii::t('default',"Sort Item")?>
</a>

</div>

<?php if (isset($_GET['msg'])):?>
<div class="success"><?php echo $_GET['msg']?></div>
<?php endif;?>

<form id="frm_category" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="id" value="<?php echo $_GET['id']?>">
<input type="hidden" name="action" value="addSubcategory">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<input type="hidden" name="page_name" id="page_name" value="subcategorynew">
<?php endif;?>

<div class="input_block">
 <label><?php echo Yii::t('default',"AddOn Name")?> :</label>
 <input type="text" name="subcategory_name" data-validation="required" value="<?php echo $data['subcategory_name']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Description")?> :</label>
 <textarea name="subcategory_description"><?php echo $data['subcategory_description']?></textarea>
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Discount")?> :</label>
 <input type="text" name="discount" class="small_input"  value="<?php echo $data['discount']?>" >
 <span><?php echo Yii::t('default',"Can be amount or percentage. eg 1% or 1 for amount")?></span>
</div>

<div class="input_block">
<?php if ($action!="add"):?>
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" class="uk-button uk-button-success" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategory" class="uk-button">
<?php echo Yii::t('default',"Back")?></a>
<?php else:?>
<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategory" class="uk-button">
<?php echo Yii::t('default',"Back")?></a>
<?php endif;?>
</div>

</form>