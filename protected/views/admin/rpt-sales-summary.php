<form id="frm_table_list" method="POST" class="uk-form uk-form-horizontal" >

<div class="search_wrap">
  <div class="input_block">
  <label><?php echo Yii::t('default',"Start Date")?></label>
  <input type="text" id="start_date" name="start_date" class="small_input j_date">
  </div>
  <div class="input_block">
  <label><?php echo Yii::t('default',"End Date")?></label>
  <input type="text" id="end_date" name="end_date" class="small_input j_date">
  </div>
  
  <?php 
  $order_stats=Yii::app()->functions->orderStatusList(false);    
  ?>
  <div class="input_block">
  <label><?php echo Yii::t('default',"Order Status")?></label>
  <?php echo CHtml::dropDownList('stats_id[]',array(4),(array)$order_stats,array(
  'class'=>"chosen",
  'multiple'=>true
  ))?>
  </div>
  
  <div class="action_wrap">
  <input type="button" value="<?php echo Yii::t("default","Search")?>" onclick="sales_summary_reload();" class="uk-button uk-button-success">  
  <a href="javascript:;" rel="sales-summary" class="export_btn uk-button"><?php echo Yii::t('default',"Export")?></a>
  </div>  
</div>

<input type="hidden" name="action" id="action" value="rptSalesSummary">
<input type="hidden" name="tbl" id="tbl" value="client">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="client_id">

<table id="table_list">
<thead>
<tr>
 <th width="5%"><?php echo Yii::t('default',"Item")?></th>
<th width="5%"><?php echo Yii::t('default',"Item ID")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Size")?></th>
 <th width="3%"><?php echo Yii::t('default',"Item Price")?></th>
 <th width="5%"><?php echo Yii::t('default',"Total Qty")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Total Amount")?></th>
</tr>
</thead>
</table>
<div class="clear"></div>
</form>