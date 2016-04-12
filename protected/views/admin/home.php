<div class="dashboard_wrap">

<div class="leftx">
<div id="total_sales_chart" class="chart"></div>
</div>
<div class="leftx">
<div id="total_sales_chart_by_item" class="chart"></div>
</div>
<div class="clear"></div>

 <div class="new_order_wrap">

 <div class="panel panel-default">  
  <div class="panel-heading"><?php echo Yii::t('default',"New Order List For Today")?> <?php echo date('F d, Y')?></div>
  <!--<div class="panel-body">
  </div>-->
  <!-- Table -->
  <!--<form id="frm_table_list" method="POST" >
  <input type="hidden" name="action" id="action" value="recentOrder">
  <input type="hidden" name="tbl" id="tbl" value="order">  -->
  <!--<table class="table" id="table_list2">-->
  <table id="table_list2" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
    <thead>
    <tr>
    <th width="1%"><?php echo Yii::t('default',"REFID")?></th>
    <th width="5%"><?php echo Yii::t('default',"CLient Name")?></th>
    <th width="5%"><?php echo Yii::t('default',"Trans Type")?></th>
    <th width="5%"><?php echo Yii::t('default',"Payment Type")?></th>
    <th width="5%"><?php echo Yii::t('default',"Total")?> </th>
    <th width="5%"><?php echo Yii::t('default',"Tax")?> </th>
    <th width="5%"><?php echo Yii::t('default',"Total W/Tax")?></th>    
    <th width="5%"><?php echo Yii::t('default',"Date")?> </th>
    <th width="5%"><?php echo Yii::t('default',"Status")?></th>
    <th width="5%"><?php echo Yii::t('default',"Action")?></th>    
    </tr>
    </thead>
    <tbody>  
    </tbody>
  </table>
  <!--</form>-->
 </div>
 
 </div> <!--END new_order_wrap-->

</div> <!--END dashboard_wrap-->