<?php
$data=array();
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{cooking_ref}}
	WHERE
	cook_id='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll(); 
    if (is_array($rows) && count($rows)>=1){    	    	
    	$data=$rows[0];        	
    } else $data=array();
}
if (!isset($data['cooking_name'])){
	$data['cooking_name']='';
}
if (!isset($data['status'])){
	$data['status']='';
}

/*if (!isset($_GET['id'])){
	$_GET['id']='';
}*/
if (!isset($_GET['id'])){
	$_GET['id']='';
	$action='add';
} else $action='update';
?>

<div class="leftx">
<form id="frm_item" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="id" value="<?php echo $_GET['id']?>">
<input type="hidden" name="action" value="cookingRefAdd">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<?php endif;?>

<div class="input_block">
<label><?php echo Yii::t('default',"Cooking Ref. name")?></label>
<?php echo CHtml::textField('cooking_name',$data['cooking_name'],array('data-validation'=>'required'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Status")?></label>
<?php echo CHtml::dropDownList('status',$data['status'],status_list(),array('data-validation'=>'required'))?>
</div>

<?php if ($action!="add"):?>
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" class="uk-button uk-button-success" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/cooking-ref" class="uk-button">Cancel</a>
<?php else:?>
<input type="submit" value="<?php echo Yii::t('default',"submit")?>" class="uk-button uk-button-success" >
<?php endif;?>	

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/sortcookingref" class="uk-button"><?php echo Yii::t('default',"Sort Item")?></a>

</form>
</div> <!--END LEFT-->

<div class="rightx">

<form id="frm_table_list" method="POST" >


<input type="hidden" name="action" id="action" value="cookingRefList">
<input type="hidden" name="tbl" id="tbl" value="cooking_ref">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="cook_id">

<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <!--<th><input type="checkbox" id="chk_all" class="chk_all"></th>-->
 <th><?php echo Yii::t('default',"Name")?></th> 
 <th><?php echo Yii::t('default',"Date")?></th>
</tr>
</thead>
</table>


</form>
</div> <!--END right-->
<div class="clear"></div>