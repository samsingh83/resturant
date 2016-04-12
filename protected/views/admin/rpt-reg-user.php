<?php 
$client_info='';

if (!isset($_GET['user_id'])){
	$_GET['user_id']='';
}

if (is_numeric($_GET['user_id'])){
	$client_info=yii::app()->functions->getClientInfo($_GET['user_id']);
	$client_info=$client_info[0];	
}
?>
<?php if (is_array($client_info) && count($client_info)>=1):?>
<form id="frm_item" method="POST"  >
<input type="hidden" name="user_id" value="<?php echo $_GET['user_id']?>">
<input type="hidden" name="action" value="updateClient">

<div class="input_block">
 <label><?php echo Yii::t('default',"Name")?> :</label>
 <input type="text" name="fullname" data-validation="required" value="<?php echo $client_info['fullname']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"phone")?> :</label>
 <input type="text" name="phone" data-validation="required" value="<?php echo $client_info['phone']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Mobile")?> :</label>
 <input type="text" name="mobile" data-validation="required" value="<?php echo $client_info['mobile']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Email")?> :</label>
 <input type="text" name="email" data-validation="required" value="<?php echo $client_info['email']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Delivery address")?> :</label>
 <input type="text" name="delivery_address" data-validation="required" value="<?php echo $client_info['delivery_address']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Location name")?> :</label>
 <input type="text" name="location_name"  value="<?php echo $client_info['location_name']?>" >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Password")?> :</label>
 <input type="text" name="password"  >
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Status")?> :</label>
 <?php 
 echo CHtml::dropDownList('status',$client_info['status'],client_status());
 ?> 
</div>

<div class="input_block">
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" >
<a class="uk-button" href="<?php echo Yii::app()->request->baseUrl;?>/admin/rpt-reg-user" ><?php echo Yii::t('default',"Cancel")?></a>
</div>

</form>
<?php else :?>
<form id="frm_table_list" method="POST"  class="uk-form uk-form-horizontal" >

<div class="search_wrap">
 <h4><?php echo Yii::t('default',"Filter")?></h4>
  <div class="input_block">
  <label><?php echo Yii::t('default',"Start Date")?></label>
  <input type="text" id="start_date" name="start_date" class="small_input j_date">
  </div>
  <div class="input_block">
  <label><?php echo Yii::t('default',"End Date")?></label>
  <input type="text" id="end_date" name="end_date" class="small_input j_date">
  </div>
  <div class="action_wrap">
  <input type="button" value="<?php echo Yii::t("default","Search")?>" onclick="sales_summary_reload();" class="uk-button uk-button-success">  
  <a href="javascript:;" rel="reg-user" class="export_btn uk-button"><?php echo Yii::t('default',"Export")?></a>
  </div>  
</div>

<input type="hidden" name="action" id="action" value="rptUserList">
<input type="hidden" name="tbl" id="tbl" value="client">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="client_id">

<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
<th><?php echo Yii::t('default',"ID")?></th>
 <th><?php echo Yii::t('default',"Full Name")?></th>
 <th><?php echo Yii::t('default',"Phone")?></th>
 <th><?php echo Yii::t('default',"Mobile")?></th> 
 <th><?php echo Yii::t('default',"Email")?></th> 
 <th><?php echo Yii::t('default',"Delivery address")?></th> 
 <th><?php echo Yii::t('default',"Location name")?></th> 
 <th><?php echo Yii::t('default',"Status")?></th> 
 <th><?php echo Yii::t('default',"Date")?></th>
</tr>
</thead>
</table>
<div class="clear"></div>
</form>
<?php endif;?>