<h2>Voucher</h2>

<?php
$data=array();
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{voucher}}
	WHERE
	voucher_id='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll(); 
    if (is_array($rows) && count($rows)>=1){    	    	
    	$data=$rows[0];        	
    } else $data=array();
}

if (!isset($data['size_name'])){
	$data['size_name']='';
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

<form id="frm_item" method="POST" >
<input type="hidden" name="id" value="<?php echo $_GET['id']?>">
<input type="hidden" name="action" value="addVoucher">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<?php endif;?>

<div class="input_block">
<label><?php echo Yii::t('default',"Voucher name")?></label>
<?php echo CHtml::textField('voucher_name',$data['voucher_name'],array('data-validation'=>'required'))?>
</div>


<?php if ( !isset($data['number_of_voucher'])):?>
<div class="input_block">
<label><?php echo Yii::t('default',"Number of Voucher")?></label>
<?php echo CHtml::textField('number_of_voucher',$data['number_of_voucher'],array('data-validation'=>'required','class'=>'numeric_only'))?>
<span><?php echo Yii::t("default","Number of vouchers to be generated")?></span>
</div>
<?php endif;?>

<div class="input_block">
<label><?php echo Yii::t('default',"Type")?></label>
<?php
echo CHtml::dropDownList('voucher_type',$data['voucher_type'],
Yii::app()->functions->voucherType()
)
?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Discount")?></label>
<?php echo CHtml::textField('amount',$data['amount'],array('data-validation'=>'required','class'=>'numeric_only'))?>
<span>Voucher amount discount.</span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Status")?></label>
<?php echo CHtml::dropDownList('status',$data['status'],status_list(),array('data-validation'=>'required'))?>
</div>

<?php if ($action!="add"):?>
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" class="uk-button uk-button-success" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/voucher" class="uk-button"><?php echo Yii::t('default',"Cancel")?></a>
<?php else:?>
<input type="submit" value="<?php echo Yii::t('default',"Generate Vouchers")?>" class="uk-button uk-button-success" >
<?php endif;?>	

</form>
</div> <!--END LEFT-->

<div class="rightx">

<form id="frm_table_list" method="POST" >

<input type="hidden" name="action" id="action" value="voucherList">
<input type="hidden" name="tbl" id="tbl" value="voucher">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="voucher_id">

<div class="uk-badge uk-badge-info">Click on number of voucher to list the generated vouchers code</div>
<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <!--<th><input type="checkbox" id="chk_all" class="chk_all"></th>-->
 <th width="3%"><?php echo Yii::t('default',"ID")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Voucher Name")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Nos. Of Voucher")?></th>
 <th width="5%"><?php echo Yii::t('default',"Type")?></th>
 <th width="5%"><?php echo Yii::t('default',"Discount")?></th>
 <th width="5%"><?php echo Yii::t('default',"Nos. Of used/Un-used<br/>Voucher")?></th>
 <th width="5%"><?php echo Yii::t('default',"Date")?></th>
</tr>
</thead>
</table>


</form>
</div> <!--END right-->
<div class="clear"></div>