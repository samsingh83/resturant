<?php
$data=array();
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{currency}}
	WHERE
	currency_code='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll(); 
    if (is_array($rows) && count($rows)>=1){    	    	
    	$data=$rows[0];        	
    } else $data=array();
}

if (!isset($data['currency_code'])){
	$data['currency_code']='';
}
if (!isset($data['currency_symbol'])){
	$data['currency_symbol']='';
}

if (!isset($_GET['id'])){
	$_GET['id']='';
	$action='add';
} else $action='update';
?>

<div class="leftx">

<form id="frm_item" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:"";?>">
<input type="hidden" name="action" value="addCurrency">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<?php endif;?>

<div class="input_block">
<label><?php echo Yii::t('default',"Currency Code")?></label>
<?php echo CHtml::textField('currency_code',$data['currency_code'],
array(
'required'=>'required',
'maxlength'=>"3"
))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Symbol")?></label>
<?php echo CHtml::textField('currency_symbol',$data['currency_symbol'],
array(
'required'=>'required'
))?>
<span><br/><?php echo Yii::t("default","To get symbol refer to")?> <a target="_blank" href="http://www.xe.com/symbols.php">http://www.xe.com/symbols.php</a> </span>
</div>

<?php if ($action!="add"):?>
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" class="uk-button uk-button-success" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/currency-settings" class="uk-button"><?php echo Yii::t('default',"Cancel")?></a>
<?php else:?>
<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
<?php endif;?>	


</form>
</div> <!--END LEFT-->

<div class="rightx">

<form id="frm_table_list" method="POST" >

<input type="hidden" name="action" id="action" value="currencyList">
<input type="hidden" name="tbl" id="tbl" value="currency">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="currency_code">

<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <!--<th><input type="checkbox" id="chk_all" class="chk_all"></th>-->
 <th width="2%"><?php echo Yii::t('default',"Currency Code")?></th> 
 <th width="2%"><?php echo Yii::t('default',"Symbol")?></th> 
 <th width="2%"><?php echo Yii::t('default',"Date")?></th>
</tr>
</thead>
</table>


</form>
</div> <!--END right-->
<div class="clear"></div>