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
  <a href="javascript:;" rel="sales-report" class="export_btn uk-button">Export</a>
  </div>  
</div>

<input type="hidden" name="action" id="action" value="rptSales">
<input type="hidden" name="tbl" id="tbl" value="client">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="client_id">

<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <th width="3%"><?php echo Yii::t('default',"Reference #")?></th>
 <th width="10%"><?php echo Yii::t('default',"Client Name")?></th>
 <th width="10%"><?php echo Yii::t('default',"Item")?></th>
 <th width="10%"><?php echo Yii::t('default',"Trans Type")?></th>
 <th width="10%"><?php echo Yii::t('default',"Payment Type")?></th>
 <th width="5%"><?php echo Yii::t('default',"Total")?></th>
 <th width="5%"><?php echo Yii::t('default',"Tax")?></th>
 <th width="5%"><?php echo Yii::t('default',"Total W/Tax")?></th>
 <th width="5%"><?php echo Yii::t('default',"Status")?></th>
 <th width="10%"><?php echo Yii::t('default',"Date")?></th>
 <th width="1%"></th>
</tr>
</thead>
</table>
<div class="clear"></div>
</form>