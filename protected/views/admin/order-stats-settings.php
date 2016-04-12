<?php
$data=array();
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{order_status}}
	WHERE
	stats_id='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll(); 
    if (is_array($rows) && count($rows)>=1){    	    	
    	$data=$rows[0];        	
    } else $data=array();
}

if (!isset($data['description'])){
	$data['description']='';
}
if (!isset($data['stats_id'])){
	$data['stats_id']='';
}

if (!isset($_GET['id'])){
	$_GET['id']='';
	$action='add';
} else $action='update';
?>

<div class="leftx">

<form id="frm_order_stats" method="POST" class="uk-form uk-form-horizontal">
<input type="hidden" name="stats_id" value="<?php echo $data['stats_id']?>">
<input type="hidden" name="action" value="orderStatusAdd">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<?php endif;?>

<div class="input_block">
<label><?php echo Yii::t('default',"Status")?></label>
<?php echo CHtml::textField('status',$data['description'],array('data-validation'=>'required'))?>
</div>


<?php if ($action!="add"):?>
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/order-stats-settings" class="uk-button"><?php echo Yii::t('default',"Cancel")?></a>
<?php else:?>
<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
<?php endif;?>	

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/order-set-stats" class="uk-button">
<i class="fa fa-cog"></i>
<?php echo Yii::t('default',"Settings")?>
</a>

</form>
</div> <!--END LEFT-->

<div class="rightx">

<form id="frm_table_list" method="POST" >

<input type="hidden" name="action" id="action" value="orderStatusList">
<input type="hidden" name="tbl" id="tbl" value="order_status">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="stats_id">

<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <!--<th><input type="checkbox" id="chk_all" class="chk_all"></th>-->
 <th><?php echo Yii::t('default',"ID")?></th> 
 <th><?php echo Yii::t('default',"Status")?></th>
</tr>
</thead>
</table>


</form>
</div> <!--END right-->
<div class="clear"></div>